// ── HAMBURGER MENU ──
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobile-menu');

hamburger.addEventListener('click', () => {
  mobileMenu.classList.toggle('open');
  hamburger.classList.toggle('active');
});

function closeMenu() {
  mobileMenu.classList.remove('open');
  hamburger.classList.remove('active');
}

// Close menu when clicking on a link
document.querySelectorAll('.mobile-menu a').forEach(link => {
  link.addEventListener('click', () => {
    closeMenu();
  });
});

// Close menu when clicking outside
document.addEventListener('click', (e) => {
  if (!e.target.closest('nav')) {
    closeMenu();
  }
});

// ── SMOOTH SCROLL WITH NAVBAR OFFSET ──
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    const href = this.getAttribute('href');
    if (href === '#') return;
    e.preventDefault();
    const target = document.querySelector(href);
    if (target) {
      const offset = 68;
      const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
      window.scrollTo({ top, behavior: 'smooth' });
    }
  });
});

// ── NAVBAR SCROLL EFFECT ──
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  if (window.scrollY > 80) {
    navbar.style.background = 'rgba(26,35,64,1)';
  } else {
    navbar.style.background = 'rgba(26,35,64,0.97)';
  }
});

// ── INTERSECTION OBSERVER FOR ANIMATIONS ──
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('.service-card, .credential, .stat-item, .proof-num-item, .team-card').forEach(el => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(20px)';
  el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
  observer.observe(el);
});

// ── PREVENT BODY SCROLL WHEN MOBILE MENU IS OPEN ──
function updateScrollLock() {
  if (mobileMenu.classList.contains('open')) {
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = '';
  }
}

hamburger.addEventListener('click', updateScrollLock);
document.querySelectorAll('.mobile-menu a').forEach(link => {
  link.addEventListener('click', updateScrollLock);
});

// ── IMPROVE TOUCH INTERACTION ──
document.addEventListener('touchstart', function() {}, { passive: true });

// ── CONTACT FORM HANDLER ──
const contactForm = document.getElementById('contactForm');
const formMessage = document.getElementById('formMessage');
const submitBtn = document.getElementById('submitBtn');

if (contactForm) {
  contactForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // ── VALIDAÇÃO NO CLIENTE ──
    const fullName = document.getElementById('fullName').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const email = document.getElementById('email').value.trim();
    const caseType = document.getElementById('caseType').value.trim();
    const message = document.getElementById('message').value.trim();
    
    if (!fullName || !phone || !email || !caseType || !message) {
      showFormMessage('Por favor, preencha todos os campos', 'error');
      return;
    }
    
    if (message.length < 10) {
      showFormMessage('A mensagem deve ter pelo menos 10 caracteres', 'error');
      return;
    }
    
    // ── MOSTRAR ESTADO DE CARREGAMENTO ──
    submitBtn.disabled = true;
    submitBtn.textContent = 'Enviando...';
    formMessage.style.display = 'none';
    
    try {
      // ── PREPARAR DADOS ──
      const formData = new FormData();
      formData.append('fullName', fullName);
      formData.append('phone', phone);
      formData.append('email', email);
      formData.append('caseType', caseType);
      formData.append('message', message);
      
      // ── ENVIAR PARA SERVIDOR ──
      const response = await fetch('send-email.php', {
        method: 'POST',
        body: formData
      });
      
      const result = await response.json();
      
      if (result.success) {
        showFormMessage(result.message, 'success');
        contactForm.reset();
      } else {
        showFormMessage(result.message || 'Erro ao enviar mensagem', 'error');
      }
    } catch (error) {
      console.error('Erro:', error);
      showFormMessage('Erro na conexão. Tente novamente ou use WhatsApp.', 'error');
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Enviar mensagem →';
    }
  });
}

// ── FUNÇÃO PARA MOSTRAR MENSAGENS ──
function showFormMessage(text, type) {
  formMessage.textContent = text;
  formMessage.style.display = 'block';
  
  if (type === 'success') {
    formMessage.style.background = 'rgba(37, 211, 102, 0.15)';
    formMessage.style.color = '#25D366';
    formMessage.style.borderLeft = '3px solid #25D366';
  } else {
    formMessage.style.background = 'rgba(255, 68, 68, 0.15)';
    formMessage.style.color = '#FF4444';
    formMessage.style.borderLeft = '3px solid #FF4444';
  }
  
  // ── REMOVER MENSAGEM APÓS 5 SEGUNDOS EM CASO DE SUCESSO ──
  if (type === 'success') {
    setTimeout(() => {
      formMessage.style.display = 'none';
    }, 5000);
  }
}

