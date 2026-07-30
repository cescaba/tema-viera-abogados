/**
 * Mi Tema Abogados - JavaScript Principal
 *
 * @package MiTemaAbogados
 * @since 1.0.0
 */

(function() {
	'use strict';

	/**
	 * Cuando el DOM está completamente cargado
	 */
	document.addEventListener('DOMContentLoaded', function() {
		initializeTheme();
	});

	/**
	 * Inicializar funcionalidades del tema
	 */
	function initializeTheme() {
		// Suavizar scroll a anclas
		setupSmoothScroll();

		// Funcionalidad del formulario de contacto
		setupContactForm();
	}

	/**
	 * Configurar scroll suave para enlaces de ancla
	 */
	function setupSmoothScroll() {
		var links = document.querySelectorAll('a[href^="#"]');
		links.forEach(function(link) {
			link.addEventListener('click', function(e) {
				var href = this.getAttribute('href');
				if (href === '#') return;

				var target = document.querySelector(href);
				if (target) {
					e.preventDefault();
					target.scrollIntoView({
						behavior: 'smooth',
						block: 'start'
					});
				}
			});
		});
	}

	/**
	 * Procesar el formulario de contacto
	 */
	function setupContactForm() {
		var form = document.getElementById('contact-form');
		if (!form) return;

		form.addEventListener('submit', function(e) {
			e.preventDefault();

			// Obtener datos del formulario
			var formData = new FormData(form);
			var data = {
				action: 'process_contact_form',
				nonce: temaVieraAbogados.nonce,
				name: formData.get('contact_name'),
				email: formData.get('contact_email_form'),
				phone: formData.get('contact_phone'),
				message: formData.get('contact_message'),
				contact_nonce: formData.get('contact_nonce')
			};

			// Enviar por AJAX (opcional)
			// Si no hay backend AJAX, el formulario se envía normalmente
			// Para una funcionalidad completa, agregar un endpoint AJAX en el backend

			console.log('Formulario de contacto:', data);
			// Aquí se podría hacer un fetch a admin-ajax.php si lo requiere
		});
	}

	/**
	 * Función auxiliar para hacer peticiones AJAX
	 */
	window.miTemaAjax = function(data, callback) {
		fetch(temaVieraAbogados.ajaxUrl, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			body: new URLSearchParams(data)
		})
			.then(response => response.json())
			.then(result => {
				if (callback && typeof callback === 'function') {
					callback(result);
				}
			})
			.catch(error => console.error('Error en AJAX:', error));
	};

	document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.getElementById('menu-toggle');
  const siteNav = document.getElementById('site-nav');

  if (menuToggle && siteNav) {
    menuToggle.addEventListener('click', function() {
      menuToggle.classList.toggle('is-active');
      siteNav.classList.toggle('is-active');
    });
  }
});

	window.addEventListener('load', function() {
  const preloader = document.getElementById('preloader');
  
  if (preloader) {
    setTimeout(function() {
      preloader.classList.add('is-hidden');
      setTimeout(function() {
        preloader.remove();
      }, 800);
    }, 2300);
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const track = document.getElementById('awards-track');
  const nextBtn = document.getElementById('awards-next-btn');
  
  if (!track) return;

  const items = track.querySelectorAll('.award-item');
  const totalItems = items.length;
  
  if (totalItems <= 3) {
    if(nextBtn) nextBtn.style.display = 'none';
    return;
  }

  let currentIndex = 0;
  let intervalId;
  const timeDelay = 4000;

  function updateSliderPosition() {
    const itemsPerView = 3;
    
    const maxIndex = Math.max(0, totalItems - itemsPerView);
    
    if (currentIndex > maxIndex) {
      currentIndex = 0;
    }

    let moveAmount = 0;
    for (let i = 0; i < currentIndex; i++) {
      moveAmount += items[i].getBoundingClientRect().width;
    }
    track.style.transform = `translateX(-${moveAmount}px)`;
  }

  function slideNext() {
    const itemsPerView = 3;
    const maxIndex = Math.max(0, totalItems - itemsPerView);

    currentIndex += itemsPerView; 
    
    if (currentIndex > maxIndex) {
      currentIndex = 0;
    }
    
    updateSliderPosition();
  }

  function startAutoPlay() {
    intervalId = setInterval(slideNext, timeDelay);
  }

  function resetTimer() {
    clearInterval(intervalId);
    startAutoPlay();
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      slideNext();
      resetTimer();
    });
  }

  window.addEventListener('resize', () => {
    currentIndex = 0;
    updateSliderPosition();
  });

  startAutoPlay();
});

document.addEventListener('DOMContentLoaded', function() {
  
  const slideElements = document.querySelectorAll('.slide-element');

  if (slideElements.length > 0) {
    const observerOptions = {
      root: null,
      rootMargin: '0px',
      threshold: 0.2 // La animación arranca cuando el 20% del elemento es visible
    };

    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    slideElements.forEach(el => {
      observer.observe(el);
    });
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const gridView = document.getElementById('servicios-grid');
  const expandedView = document.getElementById('servicios-expanded-view');
  const sectionServicios = document.getElementById('servicios');

  if (!gridView || !expandedView) return;

  const cards = gridView.querySelectorAll('.service-card-viera');
  const totalCards = cards.length;


  const expTitle = document.getElementById('expanded-title');
  const expDesc = document.getElementById('expanded-description');
  const expList = document.getElementById('expanded-list-side');
  const btnOcultar = document.getElementById('btn-ocultar');
  const expandedMainPanel = document.querySelector('.expanded-main-panel');
  const previewWrapper = document.querySelector('.next-preview-wrapper');

  const previewContainer = document.getElementById('expanded-next-preview');
  const previewTitle = document.getElementById('preview-title');
  const previewDesc = document.getElementById('preview-description-text');
  const btnNextArrow = document.getElementById('btn-next-arrow');

  let currentIndex = 0;

  function renderExpanded(index) {
    const isAlreadyVisible = expandedView.style.display === 'grid';

    currentIndex = index;
    const card = cards[index];

    const title = card.getAttribute('data-titulo');
    const desc = card.getAttribute('data-descripcion');
    let detalles = [];
    try {
      detalles = JSON.parse(card.getAttribute('data-detalles') || '[]');
    } catch(e) {
      detalles = [];
    }

    function fillContent() {
      expTitle.textContent = title;
      expDesc.textContent = desc;

      expList.innerHTML = '';
      detalles.forEach(item => {
        if (item.trim() !== '') {
          const div = document.createElement('div');
          div.className = 'expanded-list-item';
          const boldMatch = item.trim().match(/^\*\*\s*(.+?)\s*\*\*$/);
          if (boldMatch) {
            div.classList.add('expanded-list-item--bold');
            div.textContent = boldMatch[1];
          } else {
            div.textContent = item;
          }
          expList.appendChild(div);
        }
      });

      const nextIndex = (index + 1) % totalCards;
      const nextCard = cards[nextIndex];

      previewTitle.textContent = nextCard.getAttribute('data-titulo');
      previewDesc.textContent = nextCard.getAttribute('data-descripcion');
      previewContainer.setAttribute('data-next-index', nextIndex);
    }

    if (isAlreadyVisible && expandedMainPanel) {
      const totalElements = previewWrapper ? 2 : 1;

      expandedMainPanel.classList.add('switch-out');
      if (previewWrapper) previewWrapper.classList.add('switch-out');

      let transitionsDone = 0;
      function onTransitionEnd() {
        transitionsDone++;
        if (transitionsDone >= totalElements) {
          fillContent();
          expandedMainPanel.classList.remove('switch-out');
          expandedMainPanel.classList.add('switch-in');
          if (previewWrapper) {
            previewWrapper.classList.remove('switch-out');
            previewWrapper.classList.add('switch-in');
          }

          let animationsDone = 0;
          function onAnimationEnd() {
            animationsDone++;
            if (animationsDone >= totalElements) {
              expandedMainPanel.classList.remove('switch-in');
              if (previewWrapper) previewWrapper.classList.remove('switch-in');
            }
          }
          expandedMainPanel.addEventListener('animationend', onAnimationEnd, { once: true });
          if (previewWrapper) previewWrapper.addEventListener('animationend', onAnimationEnd, { once: true });
        }
      }
      expandedMainPanel.addEventListener('transitionend', onTransitionEnd, { once: true });
      if (previewWrapper) previewWrapper.addEventListener('transitionend', onTransitionEnd, { once: true });

      sectionServicios.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
      fillContent();
      gridView.style.display = 'none';
      expandedView.style.display = 'grid';
      sectionServicios.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  cards.forEach((card, index) => {
    const btnVerMas = card.querySelector('.btn-ver-mas');
    btnVerMas.addEventListener('click', (e) => {
      e.preventDefault();
      renderExpanded(index);
    });
  });

  if (btnOcultar) {
    btnOcultar.addEventListener('click', (e) => {
      e.preventDefault();
      expandedView.style.display = 'none';
      gridView.style.display = 'grid';
      sectionServicios.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  }

  function goToNextService() {
    const nextIndex = parseInt(previewContainer.getAttribute('data-next-index'), 10);
    renderExpanded(nextIndex);
  }

  if (btnNextArrow) {
    btnNextArrow.addEventListener('click', (e) => {
      e.stopPropagation();
      goToNextService();
    });
  }

  if (previewContainer) {
    previewContainer.addEventListener('click', () => {
      goToNextService();
    });
  }
});
document.addEventListener('DOMContentLoaded', function() {
  const sectoresWrapper = document.querySelector('.sectores-wrapper');
  const sectoresListContainer = document.getElementById('sectores-list');
  const sectorHeaders = document.querySelectorAll('.sector-header');
  const mainImage = document.getElementById('experiencia-img-main');

  if (!sectorHeaders.length || !mainImage) return;

  function updateWrapperState() {
    const anyOpen = document.querySelector('.sector-item.is-open');
    if (sectoresWrapper) {
      sectoresWrapper.classList.toggle('has-open', !!anyOpen);
    }
  }

  updateWrapperState();

  function updateImage(newImageUrl) {
    if (newImageUrl && mainImage.src !== newImageUrl) {
      mainImage.style.opacity = 0.5;
      setTimeout(() => {
        mainImage.src = newImageUrl;
        mainImage.onload = () => {
          mainImage.style.opacity = 1;
        };
      }, 150);
    }
  }

  sectorHeaders.forEach(header => {
    
    header.addEventListener('mouseenter', function() {
      const anyOpen = document.querySelector('.sector-item.is-open');
      if (anyOpen) return;
      const parentLi = this.parentElement;
      updateImage(parentLi.getAttribute('data-image'));
    });

    header.addEventListener('click', function() {
      const parentLi = this.parentElement;
      const isCurrentlyOpen = parentLi.classList.contains('is-open');

      document.querySelectorAll('.sector-item').forEach(el => {
        el.classList.remove('is-open');
      });

      if (!isCurrentlyOpen) {
        parentLi.classList.add('is-open');
        sectoresListContainer.scrollTo({ top: 0, behavior: 'smooth' });
        updateImage(parentLi.getAttribute('data-image'));
      } else {
        const firstSector = document.querySelector('.sector-item');
        if (firstSector) {
          updateImage(firstSector.getAttribute('data-image'));
        }
      }

      updateWrapperState();
    });
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const sectionClientes = document.getElementById('clientes');
  if (!sectionClientes) return;

  let expanded = false;
  let logosAnimated = false;

  function expandAndAnimate() {
    if (expanded) return;
    expanded = true;
    sectionClientes.classList.remove('is-collapsed');

    setTimeout(() => {
      if (logosAnimated) return;
      logosAnimated = true;
      const wrappers = sectionClientes.querySelectorAll('.cliente-logo-wrapper');
      wrappers.forEach((wrapper, index) => {
        setTimeout(() => {
          wrapper.classList.add('is-visible');
            }, index * 250);
      });
    }, 1000);
  }

  const rect = sectionClientes.getBoundingClientRect();
  const windowHeight = window.innerHeight;
  if (rect.top < windowHeight * 0.60 && rect.bottom > 0) {
    expandAndAnimate();
    return;
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !expanded) {
        expandAndAnimate();
      }
    });
  }, {
    root: null,
    rootMargin: '0px',
    threshold: 0.40
  });

  observer.observe(sectionClientes);
});

document.addEventListener('DOMContentLoaded', function() {
  const track = document.getElementById('equipo-track');
  const dotsContainer = document.getElementById('equipo-dots');
  
  if (!track || !dotsContainer) return;

  const cards = track.querySelectorAll('.miembro-card');
  const totalCards = cards.length;
  
  if (totalCards === 0) return;

  let currentPage = 0;
  
  function getCardsPerView() {
    return window.innerWidth <= 768 ? 1 : 2;
  }

  function getTotalPages() {
    return Math.ceil(totalCards / getCardsPerView());
  }

  function renderSlider() {
    const totalPages = getTotalPages();
    
    dotsContainer.innerHTML = '';
    
    if (totalPages <= 1) {
      track.style.transform = `translateX(0)`;
      return;
    }

    if (currentPage >= totalPages) currentPage = totalPages - 1;

    for (let i = 0; i < totalPages; i++) {
      const dot = document.createElement('div');
      dot.classList.add('equipo-dot');
      if (i === currentPage) dot.classList.add('is-active');
      
      dot.addEventListener('click', () => {
        currentPage = i;
        updateSliderPosition();
      });
      
      dotsContainer.appendChild(dot);
    }
    
    updateSliderPosition();
  }

  function updateSliderPosition() {
    const totalPages = getTotalPages();
    const cardsPerView = getCardsPerView();
    
    if (currentPage >= totalPages) currentPage = totalPages - 1;

    const dots = dotsContainer.querySelectorAll('.equipo-dot');
    dots.forEach((dot, idx) => {
      dot.classList.toggle('is-active', idx === currentPage);
    });

    const cardWidth = cards[0].offsetWidth;
    const gap = 20; 
    const moveAmount = (cardWidth + gap) * cardsPerView * currentPage;
    
    track.style.transform = `translateX(-${moveAmount}px)`;
  }

  renderSlider();

  window.addEventListener('resize', () => {
    setTimeout(renderSlider, 100);
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const kpiSection = document.getElementById('kpis');
  if (!kpiSection) return;

  const counters = document.querySelectorAll('.kpi-counter');
  const speed = 200;

  const animateCounters = () => {
    counters.forEach(counter => {
      const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;

        const inc = target / speed;

        if (count < target) {
          counter.innerText = Math.ceil(count + inc);
          setTimeout(updateCount, 15);
        } else {
          counter.innerText = target;
        }
      };

      updateCount();
    });
  };

  const kpiObserverOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.5
  };

  const kpiObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounters();
        observer.unobserve(entry.target);
      }
    });
  }, kpiObserverOptions);

  kpiObserver.observe(kpiSection);
});


document.addEventListener('DOMContentLoaded', function() {
  const btnCargarMas = document.getElementById('btn-cargar-noticias');
  const noticiasContainer = document.getElementById('noticias-container');
  
  if (!btnCargarMas || !noticiasContainer) return;

  btnCargarMas.addEventListener('click', function() {
    const hiddenBlocks = noticiasContainer.querySelectorAll('.noticias-block.d-none');
    
    if (hiddenBlocks.length > 0) {
      hiddenBlocks[0].style.opacity = '0';
      hiddenBlocks[0].classList.remove('d-none');
      
      setTimeout(() => {
        hiddenBlocks[0].style.transition = 'opacity 0.5s ease';
        hiddenBlocks[0].style.opacity = '1';
      }, 50);

      if (hiddenBlocks.length === 1) {
        btnCargarMas.style.display = 'none';
      }
    }
  });
});
})();
