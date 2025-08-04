/*=========menu icon navbar========*/
let menuIcon = document.querySelector('#menu-icon');
let navbar = document.querySelector(".navbar");



menuIcon.onclick = () => {
  menuIcon.classList.toggle('bx-x');
  navbar.classList.toggle('active');
};

/*=========scroll sections active link========*/
let sections = document.querySelectorAll('section');
let navLinks = document.querySelectorAll('header nav a');

window.onscroll = () => {
  sections.forEach(sec => {
    let top = window.scrollY;
    let offset = sec.offsetTop - 150;
    let height = sec.offsetHeight;
    let id = sec.getAttribute('id');

    if (top >= offset && top < offset + height) {
      navLinks.forEach(link => {
        link.classList.remove('active');
        document.querySelector('header nav a[href*="' + id + '"]').classList.add('active');
      });
    };
  });

  /*=========sticky navbar========*/
  let header = document.querySelector('header');
  header.classList.toggle('sticky', window.scrollY > 100);

  /*=========remove menu icon navbar when click navbar link(scroll)========*/
  menuIcon.classList.remove('bx-x');
  navbar.classList.remove('active');
};

/*=========swiper========*/
var swiper = new Swiper(".mySwiper", {
  slidesPerView: 1,
  spaceBetween: 50,
  loop: true,
  grabCursor: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

/*=========scroll reveal========*/
ScrollReveal({
  distance: '80px',
  duration: 2000,
  delay: 200
});

ScrollReveal().reveal('.home-content, .heading', { origin: 'top' });
ScrollReveal().reveal('.home-img img, .experience-container, .portfolio-box, .testimonial-wrapper, .contact form', { origin: 'bottom' });
ScrollReveal().reveal('.home-content h1, .about-img img', { origin: 'left' });
ScrollReveal().reveal('.home-content h3, .home-content p, .about-content', { origin: 'right' });

/*=========DOMContentLoaded Initialization========*/
document.addEventListener('DOMContentLoaded', function () {
  /*=========dark light mode with persistence========*/
  let darkModeIcon = document.querySelector('#darkMode-icon');

  // Load saved theme
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'dark') {
    document.body.classList.add('dark-mode');
    darkModeIcon.classList.add('bx-sun');
  }

  // Toggle and save theme
  darkModeIcon.onclick = () => {
    darkModeIcon.classList.toggle('bx-sun');
    document.body.classList.toggle('dark-mode');

    // Save the preference
    if (document.body.classList.contains('dark-mode')) {
      localStorage.setItem('theme', 'dark');
    } else {
      localStorage.setItem('theme', 'light');
    }
  };

  // Skills & Expertise Interactive Functionality
  const categoryItems = document.querySelectorAll('.category-item');
  const skillCategories = document.querySelectorAll('.skills-category');

  function animateSkillBars(category) {
    const skillBars = category.querySelectorAll('.skill-progress');
    skillBars.forEach((bar, index) => {
      const width = bar.getAttribute('data-width');
      bar.style.width = '0%';
      setTimeout(() => {
        bar.style.width = width + '%';
      }, index * 100 + 200);
    });
  }

  function switchCategory(targetCategory) {
    categoryItems.forEach(item => item.classList.remove('active'));
    skillCategories.forEach(category => category.classList.remove('active'));

    const activeItem = document.querySelector(`[data-category="${targetCategory}"]`);
    if (activeItem) activeItem.classList.add('active');

    const targetCategoryElement = document.getElementById(targetCategory);
    if (targetCategoryElement) {
      targetCategoryElement.classList.add('active');
      setTimeout(() => animateSkillBars(targetCategoryElement), 100);
    }

    // ARIA attributes update
    categoryItems.forEach(item => item.setAttribute('aria-selected', 'false'));
    skillCategories.forEach(category => category.setAttribute('aria-hidden', 'true'));
    if (activeItem) activeItem.setAttribute('aria-selected', 'true');
    if (targetCategoryElement) targetCategoryElement.setAttribute('aria-hidden', 'false');
  }

  categoryItems.forEach(item => {
    item.addEventListener('click', () => {
      const category = item.getAttribute('data-category');
      enhancedSwitchCategory(category);
    });

    item.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        const category = item.getAttribute('data-category');
        enhancedSwitchCategory(category);
      }
    });

    item.setAttribute('tabindex', '0');
    item.setAttribute('role', 'tab');
    item.setAttribute('aria-controls', item.getAttribute('data-category'));
  });

  skillCategories.forEach((category, index) => {
    category.setAttribute('role', 'tabpanel');
    category.setAttribute('aria-hidden', index !== 0 ? 'true' : 'false');
  });

  // Default active category
  animateSkillBars(document.querySelector('.skills-category.active'));

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const activeCategory = document.querySelector('.skills-category.active');
        if (activeCategory) animateSkillBars(activeCategory);
      }
    });
  }, {
    threshold: 0.3,
    rootMargin: '0px 0px -50px 0px'
  });

  const skillsSection = document.querySelector('.skills-section');
  if (skillsSection) observer.observe(skillsSection);

  categoryItems.forEach(item => {
    item.addEventListener('mouseenter', () => {
      if (!item.classList.contains('active')) item.style.transform = 'translateX(8px)';
    });
    item.addEventListener('mouseleave', () => {
      if (!item.classList.contains('active')) item.style.transform = 'translateX(0)';
    });
  });

  const skillItems = document.querySelectorAll('.skill-item');
  const skillObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const skillBar = entry.target.querySelector('.skill-progress');
        const width = skillBar.getAttribute('data-width');
        setTimeout(() => skillBar.style.width = width + '%', 200);
      }
    });
  }, {
    threshold: 0.5,
    rootMargin: '0px 0px -20px 0px'
  });

  skillItems.forEach(item => skillObserver.observe(item));

  function createRipple(e) {
    const button = e.currentTarget;
    const ripple = document.createElement('span');
    const rect = button.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = e.clientX - rect.left - size / 2;
    const y = e.clientY - rect.top - size / 2;

    ripple.style.cssText = `
      position: absolute;
      width: ${size}px;
      height: ${size}px;
      left: ${x}px;
      top: ${y}px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      transform: scale(0);
      animation: ripple 0.6s ease-out;
      pointer-events: none;
    `;

    if (!document.querySelector('#ripple-styles')) {
      const style = document.createElement('style');
      style.id = 'ripple-styles';
      style.textContent = `
        @keyframes ripple {
          to {
            transform: scale(2);
            opacity: 0;
          }
        }
      `;
      document.head.appendChild(style);
    }

    button.style.position = 'relative';
    button.style.overflow = 'hidden';
    button.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
  }

  categoryItems.forEach(item => {
    item.addEventListener('click', createRipple);
  });

  function smoothScrollTo(element) {
    element.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });
  }

  function showLoadingState() {
    const skillBars = document.querySelectorAll('.skill-progress');
    skillBars.forEach(bar => bar.style.width = '0%');
  }

  function enhancedSwitchCategory(targetCategory) {
    showLoadingState();
    setTimeout(() => switchCategory(targetCategory), 100);
  }

  // Swipe gesture for mobile
  let touchStartX = 0;
  let touchEndX = 0;
  const skillsContent = document.querySelector('.skills-content');

  skillsContent.addEventListener('touchstart', e => {
    touchStartX = e.changedTouches[0].screenX;
  });

  skillsContent.addEventListener('touchend', e => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  });

  function handleSwipe() {
    const swipeThreshold = 50;
    const difference = touchStartX - touchEndX;
    const categories = Array.from(categoryItems);
    const currentActive = document.querySelector('.category-item.active');
    const currentIndex = categories.indexOf(currentActive);

    if (Math.abs(difference) > swipeThreshold) {
      if (difference > 0 && currentIndex < categories.length - 1) {
        const nextCategory = categories[currentIndex + 1].getAttribute('data-category');
        enhancedSwitchCategory(nextCategory);
      } else if (difference < 0 && currentIndex > 0) {
        const prevCategory = categories[currentIndex - 1].getAttribute('data-category');
        enhancedSwitchCategory(prevCategory);
      }
    }
  }

  console.log('Skills & Expertise section initialized successfully!');
});
