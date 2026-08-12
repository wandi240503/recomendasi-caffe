import sqlite3
import os
import requests
import re
import time

# Path Konfigurasi
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
DB_PATH = os.path.join(BASE_DIR, 'database', 'database.sqlite')
STORAGE_DIR = os.path.join(BASE_DIR, 'public', 'storage', 'cafes')

# Pastikan direktori penyimpanan ada
os.makedirs(STORAGE_DIR, exist_ok=True)

# Kumpulan URL foto kafe resolusi tinggi dari Unsplash (Estetik & Realistis)
UNSPLASH_CAFE_PHOTOS = [
    "https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=800&q=80",
    "https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=800&q=80",
    "https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&q=80",
    "https://images.unsplash.com/photo-1521017432531-fbd92d768814?w=800&q=80",
    "https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=800&q=80",
    "https://images.unsplash.com/photo-1559925393-8be0ec4767c8?w=800&q=80",
    "https://images.unsplash.com/photo-1497636577773-f1231844b336?w=800&q=80",
    "https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=800&q=80",
    "https://images.unsplash.com/photo-1463797221720-6b07e6426c24?w=800&q=80",
    "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800&q=80",
    "https://images.unsplash.com/photo-1525610553991-2bede1a236e2?w=800&q=80",
    "https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=800&q=80",
    "https://images.unsplash.com/photo-1511920170033-f8396924c348?w=800&q=80",
    "https://images.unsplash.com/photo-1507133750040-4a8f57021571?w=800&q=80",
    "https://images.unsplash.com/photo-1522992319-0365e5f11656?w=800&q=80",
]

def get_slug(name):
    slug = name.lower()
    slug = re.sub(r'[^a-z0-9]+', '-', slug)
    return slug.strip('-')

def download_cafe_photo(cafe_id, cafe_name, index):
    slug = get_slug(cafe_name)
    file_name = f"{slug}.jpg"
    file_path = os.path.join(STORAGE_DIR, file_name)
    web_url = f"/storage/cafes/{file_name}"

    photo_src = UNSPLASH_CAFE_PHOTOS[index % len(UNSPLASH_CAFE_PHOTOS)]
    
    print(f"[{cafe_id}] Mengunduh foto untuk '{cafe_name}'...")

    try:
        headers = {
            'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36'
        }
        res = requests.get(photo_src, headers=headers, timeout=15)
        if res.status_code == 200:
            with open(file_path, 'wb') as f:
                f.write(res.content)
            print(f"    └─ ✅ Foto tersimpan di: {web_url}")
            return web_url
        else:
            print(f"    └─ ⚠️ Status code: {res.status_code}")
    except Exception as e:
        print(f"    └─ ❌ Gagal: {e}")

    return None

def main():
    if not os.path.exists(DB_PATH):
        print(f"❌ Error: Database tidak ditemukan di {DB_PATH}")
        return

    conn = sqlite3.connect(DB_PATH)
    cursor = conn.cursor()

    cursor.execute("SELECT id, name FROM cafes ORDER BY id ASC")
    cafes = cursor.fetchall()

    print(f"==================================================")
    print(f"☕ PIPELINE SCRAPING FOTO KAFE AUTOMATION")
    print(f"==================================================")
    print(f"Total Kafe ditemukan di SQLite: {len(cafes)}\n")

    success_count = 0

    for idx, (cafe_id, cafe_name) in enumerate(cafes):
        web_url = download_cafe_photo(cafe_id, cafe_name, idx)
        
        if web_url:
            cursor.execute("SELECT id FROM foto_cafes WHERE cafe_id = ? AND is_primary = 1", (cafe_id,))
            existing = cursor.fetchone()

            if existing:
                cursor.execute("""
                    UPDATE foto_cafes 
                    SET url = ?, caption = ?, updated_at = CURRENT_TIMESTAMP 
                    WHERE cafe_id = ? AND is_primary = 1
                """, (web_url, cafe_name, cafe_id))
            else:
                cursor.execute("""
                    INSERT INTO foto_cafes (cafe_id, url, is_primary, caption, created_at, updated_at)
                    VALUES (?, ?, 1, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
                """, (cafe_id, web_url, cafe_name))

            conn.commit()
            success_count += 1
        
        time.sleep(0.1)

    conn.close()

    print(f"\n==================================================")
    print(f"🎉 SUKSES: {success_count}/{len(cafes)} foto kafe berhasil di-scrape & diperbarui!")
    print(f"==================================================")

if __name__ == '__main__':
    main()
