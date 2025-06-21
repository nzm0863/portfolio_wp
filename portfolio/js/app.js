const { ref, onMounted, onUnmounted, watch, nextTick } = Vue;
// const { gsap } = gsap;
// const { ScrollTrigger } = ScrollTrigger;
// gsap.registerPlugin(ScrollTrigger);

// 動画リストを定義
const app = {
  setup() {
    const themeUrl = window.themeUrl || "";
    const videoSources = [
      `${themeUrl}/video/214409_tiny.mp4`,
      `${themeUrl}/video/246856_tiny.mp4`,
      `${themeUrl}/video/253423_small.mp4`,
    ];

    // 現在の動画インデックスを管理
    const currentVideoIndex = ref(0);
    const isFading = ref(false); // フェードアニメーションの状態を管理
    // 動画の切り替えロジック
    let intervalId;

    const changeVideo = () => {
      isFading.value = true;
      setTimeout(() => {
        currentVideoIndex.value =
          (currentVideoIndex.value + 1) % videoSources.length;
        isFading.value = false;
      }, 1000); // フェードアウトの時間（1秒）
    };

    // コンポーネントがマウントされたときにタイマーを開始
    onMounted(() => {
      intervalId = setInterval(changeVideo, 10000); // 10秒ごとに切り替え
    });

    // コンポーネントがアンマウントされたときにタイマーをクリア
    onUnmounted(() => {
      if (intervalId) clearInterval(intervalId);
    });

    return {
      videoSources,
      currentVideoIndex,
      isFading,
    };
  },
};

// モバイル判定
const isMobile = window.innerWidth <= 768;

// スクロールアニメーションの設定
const scrollReveal = {
  // アニメーション済みの要素を追跡
  animatedElements: new Set(),

  // 要素が表示されているかどうかを判定（表示判定）
  isElementInViewport: (el) => {
    const rect = el.getBoundingClientRect();
    // モバイルの場合は閾値を調整
    const threshold = window.innerWidth <= 768 ? 0.5 : 0.75;
    return (
      rect.top <= (window.innerHeight || document.documentElement.clientHeight) * threshold &&
      rect.bottom >= 0
    );
  },

  // 要素が画面外に出たかどうかを判定（非表示判定）
  isElementOutOfViewport: (el) => {
    const rect = el.getBoundingClientRect();
    // モバイルの場合は閾値を調整
    const threshold = window.innerWidth <= 768 ? 0.5 : 0.75;
    return (
      rect.top > (window.innerHeight || document.documentElement.clientHeight) * threshold ||
      rect.bottom < 0
    );
  },

  // アニメーションの適用
  animate: (element, options) => {
    const {
      delay = 300,
      stagger = false,
      staggerDelay = 300,
      duration = 1000,
      special = false // 特別なアニメーション用フラグ
    } = options;

    // モバイルの場合はアニメーション時間を短縮
    const isMobile = window.innerWidth <= 768;
    const adjustedDelay = isMobile ? delay * 0.7 : delay;
    const adjustedDuration = isMobile ? duration * 0.7 : duration;

    if (element.id === "aboutImage" && special) {
      // すでにアニメーション中なら何もしない
      if (element.classList.contains("special-animation")) return;

      element.classList.add("special-animation");
      setTimeout(() => {
        element.classList.remove("special-animation");
        element.classList.add("animated");
        element.classList.remove("hidden");
        scrollReveal.animatedElements.add(element);
      }, isMobile ? 1200 : 1600); // モバイルの場合はアニメーション時間を短縮
      return;
    }

    if (element.id === 'aboutImage' && special) {
      // 特別なアニメーション（顔写真用）
      element.classList.add('special-animation');
      setTimeout(() => {
        element.classList.remove('special-animation');
        element.classList.add('animated');
        element.classList.remove('hidden');
        scrollReveal.animatedElements.add(element);
      }, isMobile ? 2000 : 3000); // モバイルの場合はアニメーション時間を短縮
    } else if (stagger && element.matches('.skill-items li')) {
      // 既存のstaggerアニメーション
      const index = Array.from(element.parentElement.children).indexOf(element);
      const staggeredDelay = adjustedDelay + (index * (isMobile ? staggerDelay * 0.7 : staggerDelay));
      
      setTimeout(() => {
        element.classList.add('animated');
        element.classList.remove('hidden');
        scrollReveal.animatedElements.add(element);
      }, staggeredDelay);
    } else {
      // 通常のアニメーション
      setTimeout(() => {
        element.classList.add('animated');
        element.classList.remove('hidden');
        scrollReveal.animatedElements.add(element);
      }, adjustedDelay);
    }
  },

  // 要素を非表示にする
  hide: (element) => {
    element.classList.remove('animated');
    element.classList.add('hidden');
    scrollReveal.animatedElements.delete(element);
  },

  // 要素の監視とアニメーションの適用
  init: () => {
    const elements = {
      "#aboutImage": {
        direction: "bottom",
        delay: 0,
        duration: 1000,
        special: true
      },
      ".works-item": {
        direction: "top",
        delay: 200,
        duration: 1000,
        stagger: true,
        staggerDelay: 200,
      },
      ".skill-items li": {
        direction: "bottom",
        delay: 200,
        duration: 1000,
        stagger: true,
        staggerDelay: 200,
      },
      "#about-caption": {
        direction: "left",
        delay: 500,
        duration: 1000,
      },
      "#contactform_table": {
        direction: "right",
        delay: 500,
        duration: 1000,
      },
    };

    // スクロールイベントの監視（スロットリング付き）
    let ticking = false;
    window.addEventListener("scroll", () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          // #aboutImageを最初に処理
          if (elements["#aboutImage"]) {
            const element = document.querySelector("#aboutImage");
            if (element) {
              if (scrollReveal.isElementInViewport(element)) {
                scrollReveal.animate(element, elements["#aboutImage"]);
              } else if (scrollReveal.isElementOutOfViewport(element)) {
                scrollReveal.hide(element);
              }
            }
          }
          // 残りの要素を処理
          Object.entries(elements).forEach(([selector, options]) => {
            if (selector === "#aboutImage") return; // すでに処理済み
            if (selector === '.skill-items li' || selector === '.works-item') {
              const elements = document.querySelectorAll(selector);
              elements.forEach(element => {
                if (scrollReveal.isElementInViewport(element)) {
                  scrollReveal.animate(element, options);
                } else if (scrollReveal.isElementOutOfViewport(element)) {
                  scrollReveal.hide(element);
                }
              });
            } else {
              const element = document.querySelector(selector);
              if (element) {
                if (scrollReveal.isElementInViewport(element)) {
                  scrollReveal.animate(element, options);
                } else if (scrollReveal.isElementOutOfViewport(element)) {
                  scrollReveal.hide(element);
                }
              }
            }
          });
          ticking = false;
        });
        ticking = true;
      }
    });

    // 初期表示時にも同様に#aboutImageを最初に処理
    if (elements["#aboutImage"]) {
      const element = document.querySelector("#aboutImage");
      if (element && scrollReveal.isElementInViewport(element)) {
        scrollReveal.animate(element, elements["#aboutImage"]);
      }
    }
    Object.entries(elements).forEach(([selector, options]) => {
      if (selector === "#aboutImage") return;
      if (selector === '.skill-items li' || selector === '.works-item') {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
          if (scrollReveal.isElementInViewport(element)) {
            scrollReveal.animate(element, options);
          }
        });
      } else {
        const element = document.querySelector(selector);
        if (element && scrollReveal.isElementInViewport(element)) {
          scrollReveal.animate(element, options);
        }
      }
    });
  },
};

// DOMContentLoadedイベントで初期化
document.addEventListener("DOMContentLoaded", () => {
  scrollReveal.init();

  // 顔画像のロード完了を待ってアニメーション
  const aboutImage = document.getElementById("aboutImage");
  if (aboutImage && !aboutImage.complete) {
    aboutImage.addEventListener("load", () => {
      scrollReveal.animate(aboutImage, {
        direction: "bottom",
        delay: 0,
        duration: 1000,
        special: true
      });
    });
  } else if (aboutImage) {
    // すでに読み込み済みの場合
    scrollReveal.animate(aboutImage, {
      direction: "bottom",
      delay: 0,
      duration: 1000,
      special: true
    });
  }

  const hamburger = document.querySelector('.hamburger');
  const nav = document.querySelector('header nav');

  if (hamburger && nav) {
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      nav.classList.toggle('open');
    });
  }
});

// ハンバーガー
const navOpen = ref(false);

// gsap
// onMounted(() => {
//   gsap.registerPlugin(ScrollTrigger);
//   // ここで直接gsapアニメーションを実行
//   gsap.from("#headline", {
//     duration: 1,
//     x: -100,
//     opacity: 0,
//     ease: "bounce.out",
//   });
//   gsap.from("#header-home", {
//     duration: 1,
//     y: -100,
//     opacity: 0,
//     ease: "bounce.out",
//     delay: 0.2,
//   });
//   gsap.from("#header-works", {
//     duration: 1,
//     y: -100,
//     opacity: 0,
//     ease: "bounce.out",
//     delay: 0.4,
//   });
//   gsap.from("#header-skill", {
//     duration: 1,
//     y: -100,
//     opacity: 0,
//     ease: "bounce.out",
//     delay: 0.6,
//   });
//   gsap.from("#header-about", {
//     duration: 1,
//     y: -100,
//     opacity: 0,
//     ease: "bounce.out",
//     delay: 0.8,
//   });
//   gsap.from("#header-contact", {
//     duration: 1,
//     y: -100,
//     opacity: 0,
//     ease: "bounce.out",
//     delay: 1.0,
//   });
//   gsap.from(".hero h2", {
//     duration: 3,
//     y: -100,
//     opacity: 0,
//     delay: 1.4,
//     rotation: 360,
//     ease: "elastic.out(1, 0.3)",
//   });
//   gsap.from(".hamburger", {
//     duration: 3,
//     y: -100,
//     opacity: 0,
//     delay: 0.2,
//     rotation: 360,
//     ease: "elastic.out(1, 0.3)",
//   });
//   gsap.from(".video-container video", {
//     scale: 2,
//     duration: 3,
//     ease: "power2.out",
//   });

//   gsap.from("#aboutImage", {
//     scale: 0.4,
//     opacity: 0,
//     rotate: 720,
//     duration: 4,
//     y: 300,
//     ease: "elastic.out(1, 0.5)",
//     scrollTrigger: {
//       trigger: "#aboutImage",
//       start: "top 80%",
//       toggleActions: "restart none none none",
//     },
//   });
// });

// WordPress
const skills = ref([]);

onMounted(async () => {
  const res = await fetch("/wp-json/wp/v2/skill?_embed");
  const data = await res.json();
  skills.value = data.map((item) => ({
    id: item.id,
    title: item.title || { rendered: "" },
    content: item.content || { rendered: "" },
    featured_media_url:
      item._embedded?.["wp:featuredmedia"]?.[0]?.source_url || "",
    skill_link: item.skill_link || "",
  }));
});

const works = ref([]);

watch(works, async (newWorks) => {
  if (newWorks.length > 0) {
    await nextTick();
    ScrollReveal().reveal(".works-item", {
      delay: 100,
      origin: "bottom",
      duration: 1000,
      easing: "ease-in-out",
      reset: true,
    });
  }
});



onMounted(async () => {
  const res = await fetch("/wp-json/wp/v2/works?_embed");
  const data = await res.json();
  works.value = data.map((item) => ({
    id: item.id,
    title: item.title || { rendered: "" },
    content: item.content || { rendered: "" },
    featured_media_url:
      item._embedded?.["wp:featuredmedia"]?.[0]?.source_url || "",
    work_link: item.work_link || "",
  }));
});

Vue.createApp(app).mount("#app");

// skills取得後にgsapアニメーションを実行
// watch(skills, async (newSkills) => {
//   if (newSkills.length > 0) {
//     await nextTick();
//     gsap.utils.toArray(".skill-item").forEach((el) => {
//       gsap.from(el, {
//         scale: 0.7,
//         opacity: 0,
//         y: 80,
//         rotate: 45,
//         duration: 1.4,
//         ease: "elastic.out(1, 0.5)",
//         scrollTrigger: {
//           trigger: el,
//           start: "top 80%",
//           toggleActions: "restart none none none",
//         },
//       });
//     });
//   }
// });

// リサイズイベントの処理を追加
let resizeTimeout;
window.addEventListener('resize', () => {
  clearTimeout(resizeTimeout);
  resizeTimeout = setTimeout(() => {
    // 画面サイズが変更された時にアニメーションを再評価
    const aboutImage = document.getElementById("aboutImage");
    if (aboutImage) {
      if (scrollReveal.isElementInViewport(aboutImage)) {
        scrollReveal.animate(aboutImage, {
          direction: "bottom",
          delay: 0,
          duration: 1000,
          special: true
        });
      }
    }
  }, 250); // 250msのディレイで実行
});