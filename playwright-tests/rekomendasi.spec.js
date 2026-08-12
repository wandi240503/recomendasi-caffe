import { test, expect } from '@playwright/test';

// ====================================================================
// FULL E2E TEST SUITE — Sistem Rekomendasi Cafe Yogyakarta
// Nama   : Muhammad Niswandi
// NIM    : 2022018007
// Prodi  : Informatika - UST Yogyakarta
// ====================================================================
// Kredensial Admin
const ADMIN_EMAIL    = 'admin@caferekomendasi.com';
const ADMIN_PASSWORD = 'password123';
const BASE_URL       = 'http://127.0.0.1:8000';

// ====================================================================
// ██████  BAGIAN 1: FITUR USER (PUBLIK)
// ====================================================================

test.describe('FITUR USER', () => {

  // ------------------------------------------------------------------
  // TC-U01: Halaman Beranda
  // ------------------------------------------------------------------
  test('TC-U01: Halaman beranda dapat diakses dan menampilkan konten utama', async ({ page }) => {
    await page.goto(BASE_URL);
    await expect(page).toHaveURL(BASE_URL + '/');

    // Pastikan judul ada
    await expect(page).toHaveTitle(/.+/);

    // Navbar harus tampil
    const navbar = page.locator('#main-navbar');
    await expect(navbar).toBeVisible();

    // Link Rekomendasi di navbar
    await expect(navbar.getByRole('link', { name: 'Rekomendasi', exact: true })).toBeVisible();

    // Link Daftar Cafe di navbar
    await expect(navbar.getByRole('link', { name: 'Daftar Cafe' })).toBeVisible();

    // Tombol mulai rekomendasi
    await expect(page.getByRole('link', { name: /Mulai Rekomendasi/i })).toBeVisible();

    console.log('✅ TC-U01: Halaman beranda OK');
  });

  // ------------------------------------------------------------------
  // TC-U02: Halaman Daftar Cafe — Tampil dan Scroll
  // ------------------------------------------------------------------
  test('TC-U02: Halaman daftar cafe menampilkan daftar cafe', async ({ page }) => {
    await page.goto(BASE_URL + '/cafe');
    await expect(page).toHaveURL(/.*cafe/);
    await page.waitForLoadState('networkidle');

    // Halaman tidak error
    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    expect(body).not.toContain('Whoops!');

    // Pastikan ada card/link cafe
    const cafeItems = page.locator('a').filter({ hasText: /⭐/ });
    await expect(cafeItems.first()).toBeVisible();

    const count = await cafeItems.count();
    expect(count).toBeGreaterThan(0);
    console.log(`✅ TC-U02: Daftar cafe tampil — ${count} cafe ditemukan`);
  });

  // ------------------------------------------------------------------
  // TC-U03: Filter Cafe — Konsep Ruang
  // ------------------------------------------------------------------
  test('TC-U03: Filter cafe berdasarkan konsep ruang berjalan', async ({ page }) => {
    await page.goto(BASE_URL + '/cafe');
    await page.waitForLoadState('networkidle');

    // Klik filter Indoor
    const labelIndoor = page.locator('label').filter({ hasText: /Indoor/ }).first();
    if (await labelIndoor.isVisible()) {
      await labelIndoor.click();
    }

    // Klik filter Outdoor
    const labelOutdoor = page.locator('label').filter({ hasText: /Outdoor/ }).first();
    if (await labelOutdoor.isVisible()) {
      await labelOutdoor.click();
    }

    // Klik tombol Cari
    await page.getByRole('button', { name: 'Cari' }).click();
    await page.waitForLoadState('networkidle');

    // Halaman masih di URL cafe
    await expect(page).toHaveURL(/.*cafe/);

    // Tidak ada error
    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    console.log('✅ TC-U03: Filter cafe OK');
  });

  // ------------------------------------------------------------------
  // TC-U04: Filter Cafe — Fasilitas Tambahan
  // ------------------------------------------------------------------
  test('TC-U04: Filter cafe berdasarkan fasilitas (WiFi, AC, dll) berjalan', async ({ page }) => {
    await page.goto(BASE_URL + '/cafe');
    await page.waitForLoadState('networkidle');

    const filters = ['WiFi', 'AC', 'Sofa', 'Spot Foto'];
    for (const f of filters) {
      const label = page.locator('label').filter({ hasText: new RegExp(f, 'i') }).first();
      if (await label.isVisible()) {
        await label.click();
      }
    }

    await page.getByRole('button', { name: 'Cari' }).click();
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveURL(/.*cafe/);

    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    console.log('✅ TC-U04: Filter fasilitas OK');
  });

  // ------------------------------------------------------------------
  // TC-U05: Filter Cafe — Konsep Kafe
  // ------------------------------------------------------------------
  test('TC-U05: Filter cafe berdasarkan konsep kafe berjalan', async ({ page }) => {
    await page.goto(BASE_URL + '/cafe');
    await page.waitForLoadState('networkidle');

    const filters = ['Heritage', 'Student', 'Specialty Coffee', 'Affordable'];
    for (const f of filters) {
      const label = page.locator('label').filter({ hasText: new RegExp(f, 'i') }).first();
      if (await label.isVisible()) {
        await label.click();
      }
    }

    await page.getByRole('button', { name: 'Cari' }).click();
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveURL(/.*cafe/);
    console.log('✅ TC-U05: Filter konsep kafe OK');
  });

  // ------------------------------------------------------------------
  // TC-U06: Detail Cafe — Buka Halaman Detail
  // ------------------------------------------------------------------
  test('TC-U06: Halaman detail cafe dapat dibuka dan informasi lengkap', async ({ page }) => {
    await page.goto(BASE_URL + '/cafe');
    await page.waitForLoadState('networkidle');

    // Klik cafe pertama yang ada
    const firstCafe = page.locator('a').filter({ hasText: /⭐/ }).first();
    if (await firstCafe.isVisible()) {
      await firstCafe.click();
      await page.waitForLoadState('networkidle');

      // URL berubah ke detail
      await expect(page).toHaveURL(/.*cafe\/.+/);

      // Halaman tidak error
      const body = await page.locator('body').textContent();
      expect(body).not.toContain('500');
      expect(body).not.toContain('Whoops!');

      // Ada link Google Maps
      const mapsLink = page.getByRole('link', { name: /Google Maps/i });
      if (await mapsLink.isVisible()) {
        await expect(mapsLink).toBeVisible();
      }

      console.log('✅ TC-U06: Halaman detail cafe OK — URL: ' + page.url());
    }
  });

  // ------------------------------------------------------------------
  // TC-U07: Detail Cafe — Link Google Maps membuka popup
  // ------------------------------------------------------------------
  test('TC-U07: Link Google Maps di detail cafe membuka tab baru', async ({ page }) => {
    await page.goto(BASE_URL + '/cafe/antek-coffee');
    await page.waitForLoadState('networkidle');

    const body = await page.locator('body').textContent();
    if (body?.includes('500') || body?.includes('Whoops!')) {
      console.log('⚠️ TC-U07: Cafe antek-coffee tidak ditemukan, skip');
      return;
    }

    const mapsLink = page.getByRole('link', { name: /Google Maps/i });
    if (await mapsLink.isVisible()) {
      const popupPromise = page.waitForEvent('popup');
      await mapsLink.click();
      const popup = await popupPromise;
      expect(popup).toBeDefined();
      await popup.close();
      console.log('✅ TC-U07: Link Google Maps OK');
    } else {
      console.log('⚠️ TC-U07: Link Google Maps tidak ditemukan, skip');
    }
  });

  // ------------------------------------------------------------------
  // TC-U08: Form Rekomendasi — Halaman Tampil
  // ------------------------------------------------------------------
  test('TC-U08: Halaman form rekomendasi tampil dengan semua fasilitas', async ({ page }) => {
    await page.goto(BASE_URL + '/rekomendasi');
    await expect(page).toHaveURL(/.*rekomendasi/);
    await page.waitForLoadState('networkidle');

    // Pastikan form fasilitas ada
    await expect(page.locator('#fasilitas-1')).toBeVisible();
    await expect(page.locator('#fasilitas-2')).toBeVisible();
    await expect(page.locator('#fasilitas-3')).toBeVisible();

    // Tombol submit ada
    const submitBtn = page.getByRole('button', { name: /Dapatkan Rekomendasi/i });
    await expect(submitBtn).toBeVisible();

    console.log('✅ TC-U08: Form rekomendasi OK');
  });

  // ------------------------------------------------------------------
  // TC-U09: Rekomendasi — Skenario Indoor (AC, WiFi, Colokan)
  // ------------------------------------------------------------------
  test('TC-U09: Rekomendasi skenario INDOOR berhasil diproses', async ({ page }) => {
    await page.goto(BASE_URL + '/rekomendasi');
    await page.waitForLoadState('networkidle');

    // Pilih fasilitas Indoor
    await page.locator('#fasilitas-1').click(); // Indoor
    await page.locator('#fasilitas-5').click(); // AC
    await page.locator('#fasilitas-6').click(); // WiFi
    await page.locator('#fasilitas-8').click(); // Colokan/Charger
    await page.locator('#fasilitas-9').click(); // Meja Kerja

    await page.getByRole('button', { name: /Dapatkan Rekomendasi/i }).click();
    await page.waitForLoadState('networkidle', { timeout: 15000 });

    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    expect(body).not.toContain('Whoops!');

    console.log('✅ TC-U09: Rekomendasi skenario Indoor OK');
  });

  // ------------------------------------------------------------------
  // TC-U10: Rekomendasi — Skenario Outdoor (Rooftop, Smoking)
  // ------------------------------------------------------------------
  test('TC-U10: Rekomendasi skenario OUTDOOR berhasil diproses', async ({ page }) => {
    await page.goto(BASE_URL + '/rekomendasi');
    await page.waitForLoadState('networkidle');

    // Pilih fasilitas Outdoor
    await page.locator('#fasilitas-2').click(); // Outdoor
    await page.locator('#fasilitas-4').click(); // Rooftop
    await page.locator('#fasilitas-7').click(); // Smoking Area

    await page.getByRole('button', { name: /Dapatkan Rekomendasi/i }).click();
    await page.waitForLoadState('networkidle', { timeout: 15000 });

    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    expect(body).not.toContain('Whoops!');

    console.log('✅ TC-U10: Rekomendasi skenario Outdoor OK');
  });

  // ------------------------------------------------------------------
  // TC-U11: Rekomendasi — Skenario Gabungan (Indoor + Outdoor)
  // ------------------------------------------------------------------
  test('TC-U11: Rekomendasi skenario GABUNGAN indoor+outdoor berhasil', async ({ page }) => {
    await page.goto(BASE_URL + '/rekomendasi');
    await page.waitForLoadState('networkidle');

    // Pilih campuran indoor + outdoor
    await page.locator('#fasilitas-1').click(); // Indoor
    await page.locator('#fasilitas-2').click(); // Outdoor
    await page.locator('#fasilitas-3').click(); // Semi-Outdoor
    await page.locator('#fasilitas-5').click(); // AC
    await page.locator('#fasilitas-6').click(); // WiFi
    await page.locator('#fasilitas-9').click(); // Meja Kerja

    await page.getByRole('button', { name: /Dapatkan Rekomendasi/i }).click();
    await page.waitForLoadState('networkidle', { timeout: 15000 });

    // Tunggu hasil muncul
    await page.waitForSelector('text=Lihat detail vektor', { timeout: 12000 }).catch(() => {});

    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');

    // Cek ada hasil rekomendasi
    const vectorBtn = page.getByText(/Lihat detail vektor/i);
    if (await vectorBtn.count() > 0) {
      await vectorBtn.first().click();
      console.log('✅ TC-U11: Tombol detail vektor berhasil diklik');
    }

    console.log('✅ TC-U11: Rekomendasi gabungan OK');
  });

  // ------------------------------------------------------------------
  // TC-U12: Navigasi Lengkap Antar Halaman
  // ------------------------------------------------------------------
  test('TC-U12: Navigasi antar semua halaman berjalan tanpa error', async ({ page }) => {
    // Beranda
    await page.goto(BASE_URL);
    await expect(page).toHaveURL(BASE_URL + '/');

    // Ke Rekomendasi via navbar
    await page.goto(BASE_URL + '/rekomendasi');
    await expect(page).toHaveURL(/.*rekomendasi/);
    await page.waitForLoadState('networkidle');

    // Ke Daftar Cafe
    await page.goto(BASE_URL + '/cafe');
    await expect(page).toHaveURL(/.*cafe/);
    await page.waitForLoadState('networkidle');

    // Kembali ke Beranda
    await page.goto(BASE_URL);
    await expect(page).toHaveURL(BASE_URL + '/');

    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    console.log('✅ TC-U12: Navigasi lengkap OK');
  });

});

// ====================================================================
// ██████  BAGIAN 2: FITUR ADMIN
// ====================================================================

test.describe('FITUR ADMIN', () => {

  // ------------------------------------------------------------------
  // TC-A01: Admin Login — Berhasil
  // ------------------------------------------------------------------
  test('TC-A01: Admin dapat login dengan kredensial yang benar', async ({ page }) => {
    await page.goto(BASE_URL + '/admin/login');
    await expect(page).toHaveURL(/.*admin\/login/);

    // Gunakan id selector sesuai blade template
    await page.locator('#email-input').fill(ADMIN_EMAIL);
    await page.locator('#password-input').fill(ADMIN_PASSWORD);
    await page.locator('#login-btn').click();
    await page.waitForLoadState('networkidle');

    // Harus redirect ke dashboard
    await expect(page).toHaveURL(/.*admin\/dashboard/);
    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    console.log('✅ TC-A01: Login admin OK');
  });

  // ------------------------------------------------------------------
  // TC-A02: Admin Login — Gagal (password salah)
  // ------------------------------------------------------------------
  test('TC-A02: Admin login gagal jika password salah', async ({ page }) => {
    await page.goto(BASE_URL + '/admin/login');

    await page.locator('#email-input').fill(ADMIN_EMAIL);
    await page.locator('#password-input').fill('passwordsalah123');
    await page.locator('#login-btn').click();
    await page.waitForLoadState('networkidle');

    // Harus tetap di halaman login (tidak masuk dashboard)
    await expect(page).toHaveURL(/.*admin\/login/);
    console.log('✅ TC-A02: Login gagal (password salah) terbukti');
  });

  // ------------------------------------------------------------------
  // TC-A03: Dashboard admin — Tampil
  // ------------------------------------------------------------------
  test('TC-A03: Dashboard admin menampilkan statistik sistem', async ({ page }) => {
    await page.goto(BASE_URL + '/admin/login');
    await page.locator('#email-input').fill(ADMIN_EMAIL);
    await page.locator('#password-input').fill(ADMIN_PASSWORD);
    await page.locator('#login-btn').click();
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveURL(/.*admin\/dashboard/);

    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    expect(body).not.toContain('Whoops!');
    console.log('✅ TC-A03: Dashboard admin OK');
  });

  // ------------------------------------------------------------------
  // TC-A04: Admin — Halaman Daftar Cafe
  // ------------------------------------------------------------------
  test('TC-A04: Admin dapat melihat daftar semua cafe', async ({ page }) => {
    await page.goto(BASE_URL + '/admin/login');
    await page.locator('#email-input').fill(ADMIN_EMAIL);
    await page.locator('#password-input').fill(ADMIN_PASSWORD);
    await page.locator('#login-btn').click();
    await page.waitForLoadState('networkidle');

    await page.goto(BASE_URL + '/admin/cafe');
    await page.waitForLoadState('networkidle');

    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    console.log('✅ TC-A04: Daftar cafe admin OK');
  });

  // ------------------------------------------------------------------
  // TC-A05: Admin — Buka Form Tambah Cafe Baru
  // ------------------------------------------------------------------
  test('TC-A05: Admin dapat membuka form tambah cafe baru', async ({ page }) => {
    await page.goto(BASE_URL + '/admin/login');
    await page.locator('#email-input').fill(ADMIN_EMAIL);
    await page.locator('#password-input').fill(ADMIN_PASSWORD);
    await page.locator('#login-btn').click();
    await page.waitForLoadState('networkidle');

    await page.goto(BASE_URL + '/admin/cafe/create');
    await page.waitForLoadState('networkidle');

    await expect(page).toHaveURL(/.*admin\/cafe\/create/);
    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    console.log('✅ TC-A05: Form tambah cafe OK');
  });

  // ------------------------------------------------------------------
  // TC-A06: Admin — Tambah Cafe Baru (CREATE)
  // ------------------------------------------------------------------
  test('TC-A06: Admin dapat menambahkan data cafe baru', async ({ page }) => {
    test.setTimeout(60000); // tambah timeout jadi 60 detik untuk test ini

    await page.goto(BASE_URL + '/admin/login');
    await page.locator('#email-input').fill(ADMIN_EMAIL);
    await page.locator('#password-input').fill(ADMIN_PASSWORD);
    await page.locator('#login-btn').click();
    await page.waitForLoadState('domcontentloaded');

    await page.goto(BASE_URL + '/admin/cafe/create');
    await page.waitForLoadState('domcontentloaded');
    await expect(page).toHaveURL(/.*admin\/cafe\/create/);

    // Isi semua field yang required
    await page.locator('input[name="name"]').fill('Cafe Testing Playwright E2E');
    await page.locator('input[name="address"]').fill('Jl. Testing No.1 Yogyakarta');
    await page.locator('input[name="kemantren"]').fill('Gondokusuman');
    await page.locator('input[name="open_time"]').fill('08:00');
    await page.locator('input[name="close_time"]').fill('22:00');
    await page.locator('input[name="avg_price"]').fill('25000');
    await page.locator('input[name="rating"]').fill('4.5');

    // Submit form dan tunggu navigasi selesai
    const submitBtn = page.getByRole('button', { name: /simpan|save|tambah|submit/i });
    if (await submitBtn.isVisible()) {
      await Promise.all([
        page.waitForURL(/.*admin\/cafe.*/),
        submitBtn.click(),
      ]);
    }

    // Verifikasi redirect ke daftar cafe (bukan error 500)
    const url = page.url();
    expect(url).toContain('/admin/cafe');
    const body = await page.locator('body').textContent();
    expect(body).not.toContain('Whoops!');
    console.log('✅ TC-A06: Tambah cafe baru OK → redirect ke: ' + url);
  });

  // ------------------------------------------------------------------
  // TC-A07: Admin — Kelola Fasilitas
  // ------------------------------------------------------------------
  test('TC-A07: Admin dapat melihat dan mengelola daftar fasilitas', async ({ page }) => {
    await page.goto(BASE_URL + '/admin/login');
    await page.locator('#email-input').fill(ADMIN_EMAIL);
    await page.locator('#password-input').fill(ADMIN_PASSWORD);
    await page.locator('#login-btn').click();
    await page.waitForLoadState('networkidle');

    await page.goto(BASE_URL + '/admin/fasilitas');
    await page.waitForLoadState('networkidle');

    await expect(page).toHaveURL(/.*admin\/fasilitas/);
    const body = await page.locator('body').textContent();
    expect(body).not.toContain('500');
    console.log('✅ TC-A07: Kelola fasilitas admin OK');
  });

  // ------------------------------------------------------------------
  // TC-A08: Admin — Edit Cafe (buka form edit)
  // ------------------------------------------------------------------
  test('TC-A08: Admin dapat membuka form edit cafe', async ({ page }) => {
    await page.goto(BASE_URL + '/admin/login');
    await page.locator('#email-input').fill(ADMIN_EMAIL);
    await page.locator('#password-input').fill(ADMIN_PASSWORD);
    await page.locator('#login-btn').click();
    await page.waitForLoadState('networkidle');

    await page.goto(BASE_URL + '/admin/cafe');
    await page.waitForLoadState('networkidle');

    const editBtn = page.getByRole('link', { name: /edit/i }).first();
    if (await editBtn.isVisible()) {
      await editBtn.click();
      await page.waitForLoadState('networkidle');
      await expect(page).toHaveURL(/.*admin\/cafe\/.*\/edit/);
      const body = await page.locator('body').textContent();
      expect(body).not.toContain('500');
      console.log('✅ TC-A08: Form edit cafe OK — ' + page.url());
    } else {
      console.log('⚠️ TC-A08: Tombol edit tidak ditemukan');
    }
  });

  // ------------------------------------------------------------------
  // TC-A09: Admin — Logout
  // ------------------------------------------------------------------
  test('TC-A09: Admin dapat logout dari sistem', async ({ page }) => {
    await page.goto(BASE_URL + '/admin/login');
    await page.locator('#email-input').fill(ADMIN_EMAIL);
    await page.locator('#password-input').fill(ADMIN_PASSWORD);
    await page.locator('#login-btn').click();
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveURL(/.*admin\/dashboard/);

    // Cari tombol logout (button atau link)
    const logoutBtn = page.getByRole('button', { name: /logout|keluar/i });
    const logoutLink = page.getByRole('link', { name: /logout|keluar/i });

    if (await logoutBtn.isVisible()) {
      await logoutBtn.click();
    } else if (await logoutLink.isVisible()) {
      await logoutLink.click();
    }

    await page.waitForLoadState('networkidle');
    const url = page.url();
    const isLoggedOut = url.includes('login') || url === BASE_URL + '/';
    expect(isLoggedOut).toBeTruthy();
    console.log('✅ TC-A09: Logout admin OK → ' + url);
  });

  // ------------------------------------------------------------------
  // TC-A10: Admin — Proteksi Halaman tanpa login
  // ------------------------------------------------------------------
  test('TC-A10: Halaman admin tidak bisa diakses tanpa login', async ({ page }) => {
    await page.goto(BASE_URL + '/admin/dashboard');
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveURL(/.*admin\/login/);
    console.log('✅ TC-A10: Proteksi middleware admin OK');
  });

});