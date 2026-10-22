import * as THREE from 'three';
import { FBXLoader } from 'three/addons/loaders/FBXLoader.js';

(function () {
	'use strict';

	const viewer = document.querySelector('.apollo-model-viewer');
	if (!viewer) return;

	const canvasContainer = viewer.querySelector('.apollo-model-viewer__canvas');
	const loadingMessage = viewer.querySelector('.apollo-model-viewer__loading');
	const modelUrl = viewer.dataset.modelUrl;
	if (!canvasContainer || !loadingMessage || !modelUrl) return;

	const scene = new THREE.Scene();
	const camera = new THREE.PerspectiveCamera(34, 1, 0.1, 100);
	camera.position.set(4.5, 2.4, 6.5);
	camera.lookAt(0, 0, 0);

	const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
	renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
	renderer.outputColorSpace = THREE.SRGBColorSpace;
	renderer.toneMapping = THREE.ACESFilmicToneMapping;
	renderer.toneMappingExposure = 1.25;
	renderer.domElement.setAttribute('aria-label', 'Mô hình xe 3D — kéo chuột hoặc chạm để xoay');
	canvasContainer.appendChild(renderer.domElement);

	scene.add(new THREE.HemisphereLight(0xe7e2d8, 0x302920, 2.1));

	const keyLight = new THREE.DirectionalLight(0xfff2dc, 3.2);
	keyLight.position.set(4, 7, 5);
	scene.add(keyLight);

	const fillLight = new THREE.DirectionalLight(0x9fb7d3, 1.8);
	fillLight.position.set(-5, 3, -4);
	scene.add(fillLight);

	const rimLight = new THREE.DirectionalLight(0xc6944c, 2.1);
	rimLight.position.set(1, 2, -6);
	scene.add(rimLight);

	const turntable = new THREE.Group();
	turntable.position.set(-1, 0.55, 0);
	scene.add(turntable);

	const loader = new FBXLoader();
	loader.setResourcePath(new URL('../models/apollo-a9/', import.meta.url).href);

	let isInView = false;
	let isDragging = false;
	let previousPointerX = 0;
	let frameId = 0;
	let modelLoaded = false;
	let isLoading = false;
	let modelBounds;
	const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	const modelScale = 10.8;
	const referenceModelScale = 8.8;

	function fitCamera() {
		if (!modelBounds) return;

		const halfVerticalFov = THREE.MathUtils.degToRad(camera.fov / 2);
		const halfHorizontalFov = Math.atan(Math.tan(halfVerticalFov) * camera.aspect);
		const limitingHalfFov = Math.min(halfVerticalFov, halfHorizontalFov);
		const displayScale = modelScale / referenceModelScale;
		const distance = modelBounds.radius / displayScale / Math.sin(limitingHalfFov) * 1.04;
		const direction = new THREE.Vector3(4.5, 2.4, 6.5).normalize();

		camera.position.copy(direction.multiplyScalar(distance));
		camera.lookAt(0, 0, 0);
		camera.near = Math.max(0.1, distance / 100);
		camera.far = distance * 10;
		camera.updateProjectionMatrix();
	}

	function resizeRenderer() {
		const width = canvasContainer.clientWidth;
		const height = canvasContainer.clientHeight;
		if (!width || !height) return;

		camera.aspect = width / height;
		camera.updateProjectionMatrix();
		fitCamera();
		renderer.setSize(width, height, false);
	}

	function renderFrame() {
		frameId = 0;
		if (!isInView || !modelLoaded) return;

		if (!isDragging && !reducedMotion) {
			turntable.rotation.y += 0.003;
		}
		renderer.render(scene, camera);
		if (!isDragging && !reducedMotion) {
			frameId = window.requestAnimationFrame(renderFrame);
		}
	}

	function startRendering() {
		if (!isInView || !modelLoaded) return;
		if (reducedMotion) {
			renderer.render(scene, camera);
		} else if (!frameId) {
			frameId = window.requestAnimationFrame(renderFrame);
		}
	}

	function showError() {
		isLoading = false;
		loadingMessage.textContent = 'Không thể tải mô hình 3D. Vui lòng tải lại trang để thử lại.';
		loadingMessage.classList.add('is-error');
		loadingMessage.classList.remove('apollo-screen-reader');
	}

	function onPointerDown(event) {
		isDragging = true;
		previousPointerX = event.clientX;
		if (frameId) {
			window.cancelAnimationFrame(frameId);
			frameId = 0;
		}
		renderer.domElement.setPointerCapture(event.pointerId);
	}

	function onPointerMove(event) {
		if (!isDragging) return;
		const deltaX = event.clientX - previousPointerX;
		previousPointerX = event.clientX;
		turntable.rotation.y += deltaX * 0.008;
		renderer.render(scene, camera);
	}

	function onPointerUp() {
		isDragging = false;
		startRendering();
	}

	const resizeObserver = new ResizeObserver(resizeRenderer);
	resizeObserver.observe(canvasContainer);
	resizeRenderer();

	const visibilityObserver = new IntersectionObserver(function (entries) {
		isInView = entries.some(function (entry) { return entry.isIntersecting; });
		if (isInView && !modelLoaded && !isLoading) {
			isLoading = true;
			loader.load(
				modelUrl,
				function (model) {
					const bounds = new THREE.Box3().setFromObject(model);
					const size = bounds.getSize(new THREE.Vector3());
					const center = bounds.getCenter(new THREE.Vector3());
					const longestSide = Math.max(size.x, size.y, size.z);

					if (!Number.isFinite(longestSide) || longestSide <= 0) {
						showError();
						return;
					}

					const scale = modelScale / longestSide;
					modelBounds = new THREE.Sphere(
						new THREE.Vector3(0, 0, 0),
						bounds.getBoundingSphere(new THREE.Sphere()).radius * scale
					);
					model.scale.setScalar(scale);
					model.position.copy(center).multiplyScalar(-scale);
					model.traverse(function (object) {
						if (!object.isMesh) return;
						if (object.material) {
							const materials = Array.isArray(object.material) ? object.material : [object.material];
							materials.forEach(function (material) {
								material.side = THREE.DoubleSide;
							});
						}
					});

					turntable.add(model);
					fitCamera();
					modelLoaded = true;
					isLoading = false;
					loadingMessage.hidden = true;
					startRendering();
				},
				undefined,
				showError
			);
		}
		if (!isInView && frameId) {
			window.cancelAnimationFrame(frameId);
			frameId = 0;
		}
		startRendering();
	}, { threshold: 0.15 });

	renderer.domElement.addEventListener('pointerdown', onPointerDown);
	renderer.domElement.addEventListener('pointermove', onPointerMove);
	renderer.domElement.addEventListener('pointerup', onPointerUp);
	renderer.domElement.addEventListener('pointercancel', onPointerUp);
	visibilityObserver.observe(viewer);
}());
