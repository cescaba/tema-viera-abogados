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

	document.addEventListener('DOMContentLoaded', function() {
	  const siteHeader = document.querySelector('.site-header');
	  if (!siteHeader) return;

	  window.addEventListener('scroll', function() {
	    if (window.scrollY > 50) {
	      siteHeader.classList.add('is-scrolled');
	    } else {
	      siteHeader.classList.remove('is-scrolled');
	    }
	  });
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

  const originalItems = track.querySelectorAll('.award-item');
  const totalItems = originalItems.length;
  const itemsPerView = 3;
  
  if (totalItems <= itemsPerView) {
    if(nextBtn) nextBtn.style.display = 'none';
    return;
  }

  for (let i = 0; i < itemsPerView; i++) {
    const clone = originalItems[i].cloneNode(true);
    track.appendChild(clone);
  }

  const allItems = track.querySelectorAll('.award-item');
  const maxIndex = totalItems;

  let currentIndex = 0;
  let intervalId;
  const timeDelay = 3000;
  let isJumping = false;

  function moveToIndex(index, instant) {
    currentIndex = index;
    let moveAmount = 0;
    for (let i = 0; i < currentIndex; i++) {
      moveAmount += allItems[i].getBoundingClientRect().width;
    }
    if (instant) {
      track.classList.add('no-transition');
    }
    track.style.transform = `translateX(-${moveAmount}px)`;
    if (instant) {
      track.offsetHeight;
      track.classList.remove('no-transition');
    }
  }

  track.addEventListener('transitionend', function() {
    if (currentIndex >= maxIndex) {
      isJumping = true;
      moveToIndex(0, true);
      isJumping = false;
    }
  });

  function slideNext() {
    if (isJumping) return;
    moveToIndex(currentIndex + 1);
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
    moveToIndex(0, true);
  });

  startAutoPlay();
});

document.addEventListener('DOMContentLoaded', function() {
  var slideElements = document.querySelectorAll('.slide-element');
  if (!slideElements.length) return;

  var section = document.querySelector('.animated-text-section');
  if (!section) return;

  slideElements.forEach(function(el) {
    el.style.transition = 'none';
  });

  var ticking = false;

  function updateSlides() {
    var rect = section.getBoundingClientRect();
    var windowH = window.innerHeight;
    var startPoint = windowH;
    var endPoint = windowH * 0.25;
    var progress = (startPoint - rect.top) / (startPoint - endPoint);
    progress = Math.max(0, Math.min(1, progress));

    slideElements.forEach(function(el) {
      if (el.classList.contains('slide-left')) {
        el.style.transform = 'translateX(' + (-150 * (1 - progress)) + 'px)';
      } else {
        el.style.transform = 'translateX(' + (150 * (1 - progress)) + 'px)';
      }
      el.style.opacity = progress;
    });

    ticking = false;
  }

  window.addEventListener('scroll', function() {
    if (!ticking) {
      requestAnimationFrame(updateSlides);
      ticking = true;
    }
  });

  updateSlides();
});

document.addEventListener('DOMContentLoaded', function() {
  var sectoresWrapper = document.querySelector('.sectores-wrapper');
  var sectorHeaders = document.querySelectorAll('.sector-header');
  var mainImage = document.getElementById('experiencia-img-main');

  if (!sectorHeaders.length || !mainImage) return;

  var currentOpen = document.querySelector('.sector-item.is-open');
  var isAnimating = false;

  if (currentOpen) {
    var firstBody = currentOpen.querySelector('.sector-body');
    if (firstBody) firstBody.style.height = 'auto';
    sectoresWrapper.classList.add('has-open');
  }

  function updateImage(newImageUrl) {
    if (!newImageUrl || mainImage.src === newImageUrl) return;
    mainImage.src = newImageUrl;
  }

  function animateBody(body, open, callback) {
    var content = body.querySelector('.sector-body-content');

    if (open) {
      body.style.height = 'auto';
      var target = body.offsetHeight;
      body.style.height = '0';
      if (content) {
        content.style.transition = 'none';
        content.style.opacity = '0';
      }
      body.offsetHeight;
      body.style.transition = 'height 0.45s cubic-bezier(0.4, 0, 0.2, 1)';
      body.style.height = target + 'px';
      if (content) {
        content.style.transition = 'opacity 0.25s ease 0.15s';
        content.style.opacity = '1';
      }
    } else {
      if (content) {
        content.style.transition = 'opacity 0.15s ease';
        content.style.opacity = '0';
      }
      body.style.height = body.offsetHeight + 'px';
      body.offsetHeight;
      body.style.transition = 'height 0.35s cubic-bezier(0.4, 0, 0.2, 1)';
      body.style.height = '0';
    }

    body.addEventListener('transitionend', function onEnd(e) {
      if (e.propertyName !== 'height') return;
      body.removeEventListener('transitionend', onEnd);
      if (open) {
        body.style.height = 'auto';
        if (content) {
          content.style.transition = '';
          content.style.opacity = '';
        }
      }
      body.style.transition = '';
      if (callback) callback();
    });
  }

  sectorHeaders.forEach(function(header) {

    header.addEventListener('mouseenter', function() {
      if (isAnimating) return;
      var anyOpen = document.querySelector('.sector-item.is-open');
      if (anyOpen) return;
      updateImage(this.parentElement.getAttribute('data-image'));
    });

    header.addEventListener('click', function() {
      if (isAnimating) return;
      isAnimating = true;

      var li = this.parentElement;
      var isOpen = li.classList.contains('is-open');
      var body = li.querySelector('.sector-body');

      if (isOpen) {
        animateBody(body, false, function() {
          li.classList.remove('is-open');
          isAnimating = false;
        });
        currentOpen = null;
        sectoresWrapper.classList.remove('has-open');
        var first = document.querySelector('.sector-item');
        if (first) updateImage(first.getAttribute('data-image'));
        return;
      }

      if (currentOpen) {
        var prevBody = currentOpen.querySelector('.sector-body');
        var prevItem = currentOpen;
        animateBody(prevBody, false, function() {
          prevItem.classList.remove('is-open');
          li.classList.add('is-open');
          currentOpen = li;
          sectoresWrapper.classList.add('has-open');
          updateImage(li.getAttribute('data-image'));
          animateBody(body, true, function() {
            isAnimating = false;
          });
        });
      } else {
        li.classList.add('is-open');
        currentOpen = li;
        sectoresWrapper.classList.add('has-open');
        updateImage(li.getAttribute('data-image'));
        animateBody(body, true, function() {
          isAnimating = false;
        });
      }
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

      const wrappers = Array.from(sectionClientes.querySelectorAll('.cliente-logo-wrapper'));

      // Agrupa los logos por fila según su posición vertical.
      const rows = [];
      wrappers.forEach((wrapper) => {
        const top = Math.round(wrapper.offsetTop);
        let row = rows.find((r) => r.top === top);
        if (!row) {
          row = { top, items: [] };
          rows.push(row);
        }
        row.items.push(wrapper);
      });

      // Anima fila por fila, de arriba hacia abajo.
      rows.forEach((row, rowIndex) => {
        setTimeout(() => {
          row.items.forEach((item) => item.classList.add('is-visible'));
        }, rowIndex * 320);
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
  const section = document.getElementById('clientes');
  const btn = document.getElementById('clientes-btn-cargar');
  if (!section || !btn) return;

  btn.addEventListener('click', function() {
    section.classList.add('is-expanded');

    const belowFold = Array.from(section.querySelectorAll('.cliente-logo-wrapper.is-below-fold'));
    const perRow = 3;

    belowFold.forEach(function(wrapper, i) {
      const row = Math.floor(i / perRow);
      wrapper.style.animationDelay = (row * 220) + 'ms';
      wrapper.classList.add('is-revealed');
    });
  });
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
        startAutoplay();
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

  let autoplay = null;
  const AUTOPLAY_DELAY = 3500;

  function stopAutoplay() {
    if (autoplay) {
      clearInterval(autoplay);
      autoplay = null;
    }
  }

  function startAutoplay() {
    stopAutoplay();
    if (getTotalPages() <= 1) return;
    autoplay = setInterval(() => {
      currentPage = (currentPage + 1) % getTotalPages();
      updateSliderPosition();
    }, AUTOPLAY_DELAY);
  }

  startAutoplay();

  const sliderViewport = document.getElementById('equipo-slider-viewport');
  if (sliderViewport) {
    sliderViewport.addEventListener('mouseenter', stopAutoplay);
    sliderViewport.addEventListener('mouseleave', startAutoplay);
  }

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
      const target = +counter.getAttribute('data-target');
      let count = 0;
      const inc = target / speed;

      const updateCount = () => {
        count += inc;
        if (count < target) {
          counter.innerText = Math.ceil(count).toLocaleString('en-US');
          setTimeout(updateCount, 15);
        } else {
          counter.innerText = target.toLocaleString('en-US');
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

// Animacion fade-in escalonada para grilla de equipo
document.addEventListener('DOMContentLoaded', function() {
  var cards = document.querySelectorAll('.equipo-grid-card[data-animate]');
  if (!cards.length) return;

  var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        var card = entry.target;
        setTimeout(function() {
          card.classList.add('is-visible');
        }, Array.from(card.parentNode.children).indexOf(card) * 100);
        observer.unobserve(card);
      }
    });
  }, {
    root: null,
    rootMargin: '0px 0px 60px 0px',
    threshold: 0.1
  });

  cards.forEach(function(card) {
    observer.observe(card);
  });
});

// Animacion generica de aparicion al scroll para elementos .reveal
document.addEventListener('DOMContentLoaded', function() {
  var revealEls = document.querySelectorAll('.reveal');
  if (!revealEls.length) return;

  var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (prefersReduced || !('IntersectionObserver' in window)) {
    revealEls.forEach(function(el) {
      el.classList.add('is-visible');
    });
    return;
  }

  var revealObserver = new IntersectionObserver(function(entries, obs) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        var el = entry.target;
        var delay = parseInt(el.getAttribute('data-delay') || '0', 10);

        setTimeout(function() {
          el.classList.add('is-visible');
        }, delay);

        obs.unobserve(el);
      }
    });
  }, {
    root: null,
    rootMargin: '0px 0px -8% 0px',
    threshold: 0.15
  });

  revealEls.forEach(function(el) {
    revealObserver.observe(el);
  });
});

// Calendario y formulario de reserva (Agendar Cita)
document.addEventListener('DOMContentLoaded', function() {
  var calendar = document.getElementById('cita-calendar');
  if (!calendar) return;

  var monthLabel = document.getElementById('calendar-month');
  var daysContainer = document.getElementById('calendar-days');
  var slotsFecha = document.getElementById('calendar-slots-fecha');
  var slotsList = document.getElementById('calendar-slots-list');
  var form = document.getElementById('booking-form');
  var messageEl = document.getElementById('booking-message');
  var selectServicio = document.getElementById('booking-servicio');
  var selectTrigger = selectServicio ? selectServicio.querySelector('.booking-select-trigger') : null;
  var selectValue = selectServicio ? selectServicio.querySelector('.booking-select-value') : null;
  var selectInput = selectServicio ? selectServicio.querySelector('input[name="servicio"]') : null;

  var MESES = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
  var MESES_CORTO = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];

  var now = new Date();
  var currentYear = now.getFullYear();
  var currentMonth = now.getMonth();
  var selectedDate = null;
  var selectedSlot = null;

  function pad(n) { return (n < 10 ? '0' : '') + n; }
  function toISO(y, m, d) { return y + '-' + pad(m + 1) + '-' + pad(d); }

  function postAjax(data, cb) {
    fetch(miTemaAbogados.ajaxUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams(data)
    })
      .then(function(r) { return r.json(); })
      .then(cb)
      .catch(function() { cb({ success: false, data: { mensaje: 'Error de conexión.' } }); });
  }

  function renderMonth() {
    monthLabel.textContent = MESES[currentMonth] + ' ' + currentYear;

    var firstDay = new Date(currentYear, currentMonth, 1).getDay();
    var daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    var today = new Date();
    var todayISO = toISO(today.getFullYear(), today.getMonth(), today.getDate());

    daysContainer.innerHTML = '';

    var i;
    for (i = 0; i < firstDay; i++) {
      var empty = document.createElement('span');
      empty.className = 'calendar-day is-empty';
      daysContainer.appendChild(empty);
    }

    for (var d = 1; d <= daysInMonth; d++) {
      var iso = toISO(currentYear, currentMonth, d);
      var cell = document.createElement('button');
      cell.type = 'button';
      cell.className = 'calendar-day';
      cell.textContent = d;
      cell.setAttribute('data-date', iso);

      if (iso < todayISO) {
        cell.classList.add('is-past');
      } else {
        cell.addEventListener('click', function() {
          selectDate(this.getAttribute('data-date'));
        });
      }

      if (iso === selectedDate) cell.classList.add('is-selected');
      daysContainer.appendChild(cell);
    }
  }

  function selectDate(date) {
    selectedDate = date;
    selectedSlot = null;
    renderMonth();
    updateSlotsLabel();
    fetchSlots(date);
  }

  function updateSlotsLabel() {
    if (!selectedDate) {
      slotsFecha.textContent = '';
      return;
    }
    var parts = selectedDate.split('-');
    var m = parseInt(parts[1], 10) - 1;
    var d = parseInt(parts[2], 10);
    slotsFecha.textContent = d + ' ' + MESES_CORTO[m];
  }

  function fetchSlots(date) {
    slotsList.innerHTML = '';
    postAjax({ action: 'tema_viera_citas_slots', nonce: miTemaAbogados.nonce, fecha: date }, function(result) {
      if (result && result.success) {
        renderSlots(result.data.slots);
      }
    });
  }

  function renderSlots(slots) {
    slotsList.innerHTML = '';
    slots.forEach(function(slot) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'calendar-slot';
      btn.textContent = slot.hora;
      if (slot.ocupado) {
        btn.classList.add('is-disabled');
        btn.disabled = true;
      } else {
        btn.addEventListener('click', function() {
          selectedSlot = slot.hora;
          renderSlots(slots);
        });
      }
      if (slot.hora === selectedSlot) btn.classList.add('is-selected');
      slotsList.appendChild(btn);
    });
  }

  function showMessage(texto, tipo) {
    messageEl.textContent = texto;
    messageEl.className = 'booking-message ' + (tipo === 'success' ? 'is-success' : 'is-error');
    messageEl.hidden = false;
  }

  calendar.querySelectorAll('.calendar-nav').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var dir = parseInt(this.getAttribute('data-dir'), 10);
      currentMonth += dir;
      if (currentMonth < 0) { currentMonth = 11; currentYear--; }
      if (currentMonth > 11) { currentMonth = 0; currentYear++; }
      renderMonth();
    });
  });

  if (selectServicio && selectTrigger) {
    var toggleSelect = function(open) {
      var next = (typeof open === 'boolean') ? open : !selectServicio.classList.contains('is-open');
      selectServicio.classList.toggle('is-open', next);
      selectTrigger.setAttribute('aria-expanded', next ? 'true' : 'false');
    };

    selectTrigger.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleSelect();
    });

    selectServicio.querySelectorAll('.booking-select-option').forEach(function(option) {
      option.addEventListener('click', function() {
        var value = option.getAttribute('data-value') || '';
        if (selectInput) selectInput.value = value;
        if (selectValue) selectValue.textContent = option.textContent;

        selectServicio.querySelectorAll('.booking-select-option').forEach(function(o) {
          o.classList.toggle('is-selected', o === option);
        });

        selectTrigger.classList.toggle('has-value', value !== '');
        toggleSelect(false);
      });
    });

    document.addEventListener('click', function(e) {
      if (!selectServicio.contains(e.target)) {
        toggleSelect(false);
      }
    });
  }

  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      showMessage('', 'error');
      messageEl.hidden = true;

      var nombre = (form.querySelector('input[name="nombre"]') || {}).value || '';
      var whatsapp = (form.querySelector('input[name="whatsapp"]') || {}).value || '';
      var servicio = selectInput ? selectInput.value : '';

      if (!selectedDate) { showMessage('Selecciona un día en el calendario.', 'error'); return; }
      if (!selectedSlot) { showMessage('Selecciona un horario disponible.', 'error'); return; }
      if (!nombre.trim()) { showMessage('Ingresa tu nombre.', 'error'); return; }

      var submitBtn = form.querySelector('.booking-submit');
      var span = submitBtn ? submitBtn.querySelector('span') : null;
      var originalText = span ? span.textContent : '';
      if (submitBtn) { submitBtn.disabled = true; if (span) span.textContent = '…'; }

      postAjax({
        action: 'tema_viera_citas_book',
        nonce: miTemaAbogados.nonce,
        nombre: nombre.trim(),
        whatsapp: whatsapp.trim(),
        servicio: servicio.trim(),
        fecha: selectedDate,
        hora: selectedSlot
      }, function(result) {
        if (submitBtn) { submitBtn.disabled = false; if (span) span.textContent = originalText; }

        if (result && result.success) {
          showMessage(result.data.mensaje, 'success');

          var numero = result.data.whatsapp_numero || '';
          var waMsg = form.getAttribute('data-wa-msg') || '';
          if (numero && waMsg) {
            var datos = {
              '{nombre}': nombre.trim(),
              '{whatsapp}': whatsapp.trim(),
              '{servicio}': servicio.trim(),
              '{fecha}': selectedDate,
              '{hora}': selectedSlot
            };
            var texto = waMsg;
            Object.keys(datos).forEach(function(k) { texto = texto.split(k).join(datos[k]); });
            window.open('https://wa.me/' + numero + '?text=' + encodeURIComponent(texto), '_blank', 'noopener');
          }

          selectedSlot = null;
          fetchSlots(selectedDate);
        } else {
          var msg = (result && result.data && result.data.mensaje) ? result.data.mensaje : 'Ocurrió un error.';
          showMessage(msg, 'error');
        }
      });
    });
  }

  renderMonth();
});

})();
