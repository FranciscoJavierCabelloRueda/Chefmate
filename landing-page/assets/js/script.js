document.addEventListener('DOMContentLoaded', () => {
  efectoVideo();      
  animarLogo();               
  fotosCanvas();           
  animarTitulo();             
  activarSonido();     
});

/**
 * Efeccto de movimiento con el ratón sobre el vídeo de fondo
 */
function efectoVideo() {
  const videoFondo = document.querySelector('.background__video');
  const desplazamiento = 20;

  // Cada vez que el usuario mueve el ratón, se calcula la posición relativa
  // y se aplica una transformación al vídeo de fondo para crear efecto de profundidad
  document.addEventListener('mousemove', e => {
    const x = (e.clientX / window.innerWidth  - 0.5) * 2;
    const y = (e.clientY / window.innerHeight - 0.5) * 2;
    videoFondo.style.transform = `translate(${-x * desplazamiento}px, ${-y * desplazamiento}px) scale(1.05)`;
  });
}

/**
 * Aparece el logo al cargar con efecto de opacidad
 */
function animarLogo() {
  // Espera a que la ventana termine de cargar para lanzar la animación del logo
  window.addEventListener('load', () => {
    anime({
      targets: '#logo__chefmate',
      opacity: [0, 1],
      duration: 2000,
      easing: 'easeInOutQuad'
    });
  });
}

/**
 * Galería de imágenes con transición 
 */
function fotosCanvas() {
  // Al cargar la ventana, se prepara un canvas que mostrará imágenes una tras otra
  window.addEventListener('load', () => {
    const rutas = [
      'assets/img/carne.png',
      'assets/img/ensalada.png',
      'assets/img/pollo.png'
    ];

    const canvas = document.getElementById('layout__canvas');
    const ctx = canvas.getContext('2d');

    // Se crean los objetos Image y se cargan con las rutas anteriores
    const imagenes = rutas.map(src => {
      const img = new Image();
      img.src = src;
      return img;
    });

    let actual = 0;
    let enTransicion = false;

    // Función para dibujar una imagen con una opacidad concreta
    function pintarImagen(img, opacidad) {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.globalAlpha = opacidad;
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
      ctx.globalAlpha = 1;
    }

    // Cuando la primera imagen cargue, se muestra
    imagenes[0].onload = () => pintarImagen(imagenes[actual], 1);

    // Esta función cambia la imagen haciendo un efecto de desvanecido y aparición
    function cambiarImagen() {
      if (enTransicion) return;
      enTransicion = true;

      const siguiente = (actual + 1) % imagenes.length;
      let alpha = 1;

      function desvanecer() {
        alpha -= 0.05;
        if (alpha <= 0) {
          actual = siguiente;
          aparecer();
        } else {
          pintarImagen(imagenes[actual], alpha);
          requestAnimationFrame(desvanecer);
        }
      }

      function aparecer() {
        let alphaIn = 0;
        function animar() {
          alphaIn += 0.05;
          pintarImagen(imagenes[actual], alphaIn);
          if (alphaIn < 1) {
            requestAnimationFrame(animar);
          } else {
            enTransicion = false;
          }
        }
        animar();
      }

      desvanecer();
    }

    // Cada 5 segundos se lanza el cambio de imagen
    setInterval(() => {
      if (imagenes[actual].complete) {
        cambiarImagen();
      }
    }, 5000);
  });
}

/**
 * Aparece el titulo al cargar con efecto de opacidad
 */
function animarTitulo() {
  const titulo = document.getElementById('layout__titulo');

  // Cuando la página está lista, se anima el título para que suba y aparezca
  anime({
    targets:    titulo,
    opacity:    [0, 1],
    translateY: [50, 0],
    duration:   2000,
    easing:     'easeOutQuad'
  });
}

/**
 * Al hacer click sobre el título, se reproduce un sonido de un cuchillo
 */
function activarSonido() {
  const titulo = document.getElementById('layout__titulo');
  const audio = document.getElementById('audio');
  titulo.addEventListener('click', () => {
    audio.currentTime = 0;
    audio.play();
  });
}


