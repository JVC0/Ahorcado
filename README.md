# 🎮 Juego del Ahorcado en PHP

Este es un proyecto simple en **PHP** que implementa el clásico juego del **ahorcado** en el navegador, utilizando **sesiones** para gestionar el estado del juego.

---

## 🚀 Requisitos

- **Docker** instalado en tu sistema.
- Un navegador web moderno.
- (Opcional) Conocimientos básicos de PHP para personalizar el juego.

> 💡 El proyecto está listo para ejecutarse con **Docker**, sin necesidad de configurar un servidor web local manualmente.

---

## 📂 Estructura del proyecto

```text
C:.
│   .dockerignore
│   .DS_Store
│   docker-compose.yml
│   Dockerfile
│   php.ini
│   README.md
│
├───Data
│       words.txt                # Lista de palabras para el juego
│
├───images
│       mock.drawio.png         # Diagrama de diseño (mockup)
│
├───public
│       Games.php               # Lógica principal del juego
│       Renderer.php            # Renderizado de vistas y dibujos
│       Storage.php             # Gestión de sesiones y estado
│       WordProvider.php        # Proveedor de palabras aleatorias
│
└───src
        index.php               # Punto de entrada del juego

🔍 Nota: El archivo index.php está en /src/, pero el servidor web (configurado en Docker) lo sirve como raíz del sitio.

## 🎨 Dibujo del ahorcado

El juego muestra el progreso del ahorcado en **ASCII** según los intentos restantes:

```

+---+
| |
|
|
|
|
=========

```

```

+---+
| |
O |
|
|
|
=========

```

```

+---+
| |
O |
| |
|
|
=========

```

```

+---+
| |
O |
/| |
|
|
=========

```

```

+---+
| |
O |
/|\ |
|
|
=========

```

```

+---+
| |
O |
/|\ |
/ |
|
=========

```

```

+---+
| |
O |
/|\ |
/ \ |
|
=========

````

---

## ▶️ Cómo ejecutar el proyecto

1. Copia los archivos en la carpeta de tu servidor web local.
   Ejemplo en **XAMPP (Windows):**

   ```bash
   C:\xampp\htdocs\ahorcado\
````

Ejemplo en **Linux (con Apache):**

```bash
/var/www/html/ahorcado/
```

2. Inicia Apache desde tu servidor local.
3. Abre en el navegador:

   ```bash
   http://localhost/ahorcado/index.php
   ```

---
