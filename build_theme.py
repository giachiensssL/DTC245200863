from pathlib import Path

theme_dir = Path(__file__).resolve().parent / "wordpress" / "wp-content" / "themes" / "techpro"
for directory in (
    theme_dir,
    theme_dir / "assets" / "js",
    theme_dir / "assets" / "css",
    theme_dir / "assets" / "images",
):
    directory.mkdir(parents=True, exist_ok=True)
print("Theme directories verified.")
