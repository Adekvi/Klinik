function poliA() {
    var inputs = document.querySelectorAll('.poliA .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function anamnesisS() {
    var inputs = document.querySelectorAll('.anamnesis-s .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function anamnesisO() {
    var inputs = document.querySelectorAll('.anamnesis-o .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function formIsian() {
    var inputs = document.querySelectorAll('.form-isian .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function kebiasaan() {
    var inputs = document.querySelectorAll('.kebiasaan .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function riwayatLahir() {
    var inputs = document.querySelectorAll('.riwayat-lahir .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function tandaVital() {
    var inputs = document.querySelectorAll('.tanda-vital .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function asesmenKeperawatan() {
    var inputs = document.querySelectorAll('.asesmen-keperawatan .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function psicoPengetahuan() {
    var inputs = document.querySelectorAll('.psicososial-pengetahuan .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function asesmenNyeri() {
    var inputs = document.querySelectorAll('.asesmen-nyeri .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function asesmenResikoJatuh() {
    var inputs = document.querySelectorAll('.asesmen-resiko-jatuh .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function masalahKeperawatan() {
    var inputs = document.querySelectorAll('.masalah-keperawatan .form-group');
    inputs.forEach(function(input) {
      input.classList.toggle('hidden-input');
    });
  }
  function toggleInput(inputId) {
    var inputElement = document.getElementById(inputId);
    inputElement.classList.toggle('hidden-input');
  }

  hideInputs();

  function toggleChange(elementId, radio) {
    var element = document.getElementById(elementId);

    if (radio.value === 'Tidak') {
      element.style.display = (element.style.display === 'none' || element.style.display === '') ? 'block' : 'none';
    } else if (radio.value === 'Aloanamnesis') {
      element.style.display = (element.style.display === 'none' || element.style.display === '') ? 'block' : 'none';
    } else if (radio.value === 'Lainnya') {
      element.style.display = (element.style.display === 'none' || element.style.display === '') ? 'block' : 'none';
    }else {
      element.style.display = 'none';
    }
  }