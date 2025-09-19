// const nextBtn = document.querySelector('.next-btn');
// const prevBtn = document.querySelector('.prev-btn');
// const slides = document.querySelectorAll('.slide');
// const numberOfSlides = slides.length;
// let slideNumber = 0;

// //slider next button

// nextBtn.onclick = () => {
//   slides.forEach((slide) => {
//     slide.classList.remove('active');
//   });

//   slideNumber++;

//   if (slideNumber > numberOfSlides - 1) {
//     slideNumber = 0;
//   }
//   slides[slideNumber].classList.add('active');
// };

// //slider prev button

// prevBtn.onclick = () => {
//   slides.forEach((slide) => {
//     slide.classList.remove('active');
//   });

//   slideNumber--;

//   if (slideNumber < 0) {
//     slideNumber = numberOfSlides - 1;
//   }
//   slides[slideNumber].classList.add('active');
// };

document.addEventListener('DOMContentLoaded', function () {
  const sliders = document.querySelectorAll('.slider'); // container setiap slider
  if (!sliders.length) return;

  sliders.forEach(slider => {
    const nextBtn = slider.querySelector('.next-btn');
    const prevBtn = slider.querySelector('.prev-btn');
    const slides = slider.querySelectorAll('.slide');
    if (slides.length === 0) return;

    let slideNumber = 0;
    // pastikan slide awal aktif
    slides.forEach((s, i) => s.classList.toggle('active', i === 0));

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        slides[slideNumber].classList.remove('active');
        slideNumber = (slideNumber + 1) % slides.length;
        slides[slideNumber].classList.add('active');
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        slides[slideNumber].classList.remove('active');
        slideNumber = (slideNumber - 1 + slides.length) % slides.length;
        slides[slideNumber].classList.add('active');
      });
    }
  });
});


