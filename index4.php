<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Pengaduan - Modern UI</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right top, #dfe9f3, #ffffff);
    }
    .glass {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(14px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .form-label {
      color: #374151;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-6xl flex flex-col md:flex-row gap-10 animate__animated animate__fadeInUp">
    <div class="hidden md:flex items-center justify-center w-1/2">
      <lottie-player src="https://lottie.host/167d52c3-c44f-494f-9c04-6de47b19973c/U7uxQuD0zZ.json" background="transparent" speed="1" style="width: 100%; height: 420px;" loop autoplay></lottie-player>
    </div>

    <div class="glass p-10 rounded-3xl shadow-2xl w-full md:w-1/2" x-data="formHandler()">
      <h2 class="text-4xl font-bold text-blue-700 text-center mb-6">Form Pengaduan</h2>

      <form @submit.prevent="submitForm" class="space-y-5">
        <template x-for="(label, key) in labels" :key="key">
          <div>
            <label class="block text-sm font-medium form-label" x-text="label"></label>
            <template x-if="key === 'alamat_lengkap' || key === 'keluhan'">
              <textarea :name="key" x-model="form[key]" rows="3" class="w-full mt-1 p-3 border border-gray-300 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
            </template>
            <template x-if="key !== 'alamat_lengkap' && key !== 'keluhan'">
              <input type="text" :name="key" x-model="form[key]" class="w-full mt-1 p-3 border border-gray-300 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </template>
          </div>
        </template>

        <div class="flex justify-end pt-4">
          <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-semibold px-8 py-3 rounded-xl transition transform hover:scale-105 shadow-xl">
            Kirim Laporan
          </button>
        </div>
      </form>

      <template x-if="response">
        <div class="mt-6 p-4 rounded-xl" :class="{'bg-green-100 text-green-700': response.status === 'success', 'bg-red-100 text-red-700': response.status === 'error'}">
          <strong class="block text-lg font-bold" x-text="response.message"></strong>
          <div x-show="response.data" class="mt-2 text-sm space-y-1">
            <template x-for="(val, key) in response.data" :key="key">
              <p><b x-text="key.replace(/_/g, ' ').toUpperCase() + ':'"></b> <span x-text="val"></span></p>
            </template>
          </div>
        </div>
      </template>
    </div>
  </div>

  <script>
    function formHandler() {
      return {
        form: {
          nomor_internet: '',
          nama_pelapor: '',
          no_hp_pelapor: '',
          alamat_lengkap: '',
          keluhan: '',
          share_location: '',
          kd_tiket: ''
        },
        labels: {
          nomor_internet: 'Nomor Internet',
          nama_pelapor: 'Nama Pelapor',
          no_hp_pelapor: 'No HP Pelapor',
          alamat_lengkap: 'Alamat Lengkap',
          keluhan: 'Keluhan',
          share_location: 'Share Location',
          kd_tiket: 'Kode Tiket'
        },
        response: null,
        async submitForm() {
          try {
            const res = await fetch('insert_keluhan.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(this.form)
            });
            const data = await res.json();
            this.response = data;
            if (data.status === 'success') {
              this.form = Object.fromEntries(Object.keys(this.form).map(k => [k, '']));
            }
          } catch (error) {
            this.response = { status: 'error', message: 'Gagal mengirim data. Silakan coba lagi.' };
          }
        }
      }
    }
  </script>
</body>
</html>
