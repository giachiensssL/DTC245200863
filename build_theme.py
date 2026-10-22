import os

theme_dir = r"D:\Website_Antigravity\DU_LIEU\DeTai_TrienKhai\DTC245200863-topic3-wordpress-product\wordpress\wp-content\themes\techpro"
os.makedirs(theme_dir, exist_ok=True)
os.makedirs(os.path.join(theme_dir, "assets", "js"), exist_ok=True)
os.makedirs(os.path.join(theme_dir, "assets", "css"), exist_ok=True)
os.makedirs(os.path.join(theme_dir, "assets", "images"), exist_ok=True)
print("Theme directories verified.")
