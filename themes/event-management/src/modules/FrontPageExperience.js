import gsap from "gsap";
import * as THREE from "three";
import Swiper from "swiper";
import { Autoplay, EffectFade, Navigation, Pagination } from "swiper/modules";

class FrontPageExperience {
  constructor() {
    this.hero = document.querySelector(".front-hero");

    if (!this.hero) {
      return;
    }

    this.canvas = this.hero.querySelector(".front-hero__canvas");
    this.scene = null;
    this.camera = null;
    this.renderer = null;
    this.particles = null;
    this.animationFrame = null;
    this.pointer = { x: 0, y: 0 };

    this.initHeroSlider();
    this.initFeatureSliders();
    this.initThreeScene();
    this.events();
  }

  initHeroSlider() {
    Swiper.use([Autoplay, EffectFade, Navigation, Pagination]);

    const slideCount = document.querySelectorAll(
      ".front-events-swiper .swiper-slide",
    ).length;
    const hasMultipleSlides = slideCount > 1;
    const canLoop = slideCount >= 3;

    this.heroSwiper = new Swiper(".front-events-swiper", {
      effect: "fade",
      fadeEffect: {
        crossFade: true,
      },
      loop: canLoop,
      rewind: !canLoop && hasMultipleSlides,
      speed: 900,
      autoplay: hasMultipleSlides
        ? {
            delay: 5200,
            disableOnInteraction: false,
          }
        : false,
      navigation: hasMultipleSlides
        ? {
            nextEl: ".front-events-next",
            prevEl: ".front-events-prev",
          }
        : false,
      pagination: hasMultipleSlides
        ? {
            el: ".front-events-pagination",
            clickable: true,
          }
        : false,
      on: {
        init: () => this.animateActiveSlide(),
        slideChangeTransitionStart: () => this.animateActiveSlide(),
      },
    });
  }

  initFeatureSliders() {
    Swiper.use([Navigation, Pagination]);

    const maxFeatureSlidesPerView = 3.35;
    const minLoopSlides = Math.ceil(maxFeatureSlidesPerView) + 1;

    const configs = [
      [
        ".front-professors-swiper",
        ".front-professors-pagination",
        ".front-professors-next",
        ".front-professors-prev",
      ],
      [
        ".front-seminars-swiper",
        ".front-seminars-pagination",
        ".front-seminars-next",
        ".front-seminars-prev",
      ],
    ];

    configs.forEach(([selector, pagination, nextBtn, prevBtn]) => {
      const element = document.querySelector(selector);
      if (!element) return;

      const slideCount = element.querySelectorAll(".swiper-slide").length;
      const hasMultipleSlides = slideCount > 1;
      const canLoop = slideCount >= minLoopSlides;

      new Swiper(element, {
        loop: canLoop,
        rewind: !canLoop && hasMultipleSlides,
        spaceBetween: 24,
        slidesPerGroup: 1,
        slidesPerView: 1.08,
        pagination: {
          el: pagination,
          clickable: true,
        },
        navigation: hasMultipleSlides
          ? {
              nextEl: nextBtn,
              prevEl: prevBtn,
            }
          : false,
        breakpoints: {
          576: { slidesPerView: 1.6 },
          768: { slidesPerView: 2.35 },
          1200: { slidesPerView: maxFeatureSlidesPerView },
        },
      });
    });
  }

  animateActiveSlide() {
    const activeSlide = this.hero.querySelector(".swiper-slide-active");
    if (!activeSlide) return;

    const elements = activeSlide.querySelectorAll(
      ".front-hero__meta, .front-hero__title, .front-hero__excerpt, .front-hero__link",
    );

    gsap.fromTo(
      elements,
      { autoAlpha: 0, y: 28 },
      { autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.09, ease: "power3.out" },
    );

    if (this.particles) {
      gsap.to(this.particles.rotation, {
        y: this.particles.rotation.y + 0.32,
        duration: 1.2,
        ease: "power2.out",
      });
    }
  }

  initThreeScene() {
    if (!this.canvas) return;

    this.scene = new THREE.Scene();
    this.camera = new THREE.PerspectiveCamera(55, 1, 0.1, 100);
    this.camera.position.z = 7;

    this.renderer = new THREE.WebGLRenderer({
      canvas: this.canvas,
      alpha: true,
      antialias: true,
    });
    this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    const geometry = new THREE.BufferGeometry();
    const count = 700;
    const positions = new Float32Array(count * 3);
    const colors = new Float32Array(count * 3);
    const colorA = new THREE.Color("#ff894c");
    const colorB = new THREE.Color("#dc2f2f");
    const colorC = new THREE.Color("#f8f8f8");

    for (let index = 0; index < count; index += 1) {
      const i = index * 3;
      const radius = 2 + Math.random() * 3.4;
      const angle = Math.random() * Math.PI * 2;

      positions[i] = Math.cos(angle) * radius;
      positions[i + 1] = (Math.random() - 0.5) * 4;
      positions[i + 2] = Math.sin(angle) * radius;

      const mixed = colorA
        .clone()
        .lerp(index % 3 === 0 ? colorC : colorB, Math.random() * 0.75);
      colors[i] = mixed.r;
      colors[i + 1] = mixed.g;
      colors[i + 2] = mixed.b;
    }

    geometry.setAttribute("position", new THREE.BufferAttribute(positions, 3));
    geometry.setAttribute("color", new THREE.BufferAttribute(colors, 3));

    const material = new THREE.PointsMaterial({
      size: 0.045,
      vertexColors: true,
      transparent: true,
      opacity: 0.72,
      depthWrite: false,
    });

    this.particles = new THREE.Points(geometry, material);
    this.scene.add(this.particles);

    this.resize();
    this.renderThreeScene();
  }

  renderThreeScene() {
    if (!this.renderer || !this.scene || !this.camera || !this.particles)
      return;

    this.particles.rotation.y += 0.0018 + this.pointer.x * 0.0008;
    this.particles.rotation.x +=
      (this.pointer.y * 0.14 - this.particles.rotation.x) * 0.025;

    this.renderer.render(this.scene, this.camera);
    this.animationFrame = window.requestAnimationFrame(() =>
      this.renderThreeScene(),
    );
  }

  events() {
    window.addEventListener("resize", () => this.resize());
    this.hero.addEventListener("pointermove", (event) => {
      const bounds = this.hero.getBoundingClientRect();
      this.pointer.x = (event.clientX - bounds.left) / bounds.width - 0.5;
      this.pointer.y = (event.clientY - bounds.top) / bounds.height - 0.5;
    });
  }

  resize() {
    if (!this.renderer || !this.camera || !this.hero) return;

    const width = this.hero.clientWidth;
    const height = this.hero.clientHeight;

    this.camera.aspect = width / height;
    this.camera.updateProjectionMatrix();
    this.renderer.setSize(width, height, false);
  }
}

export default FrontPageExperience;
