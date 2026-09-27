CREATE DATABASE BDM_PIA;
USE BDM_PIA;

CREATE TABLE Usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  apellidos VARCHAR(50) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  foto VARCHAR(255),
  genero ENUM('Masculino','Femenino','Otro') NOT NULL,
  correo VARCHAR(100) UNIQUE NOT NULL,
  contraseña VARCHAR(255) NOT NULL,
  alias VARCHAR(50) UNIQUE,
  tipo_usuario ENUM('Ajustador','Supervisor','Asegurado') NOT NULL
);

CREATE TABLE Unidades (
  id_unidad INT AUTO_INCREMENT PRIMARY KEY,
  id_asegurado INT NOT NULL,
  marca VARCHAR(50) NOT NULL,
  modelo VARCHAR(50) NOT NULL,
  año INT NOT NULL,
  placas VARCHAR(20) UNIQUE,
  numero_serie VARCHAR(50) UNIQUE,
  color VARCHAR(30),
  FOREIGN KEY (id_asegurado) REFERENCES Usuarios(id_usuario)
);

CREATE TABLE Siniestros (
  id_siniestro INT AUTO_INCREMENT PRIMARY KEY,
  id_ajustador INT NOT NULL,
  id_supervisor INT,
  id_unidad INT NOT NULL,
  nombre_compania VARCHAR(100),
  direccion_compania VARCHAR(150),
  telefono_compania VARCHAR(20),
  correo_compania VARCHAR(100),
  fecha_siniestro DATETIME NOT NULL,
  ubicacion VARCHAR(150) NOT NULL,
  descripcion TEXT NOT NULL,
  numero_poliza VARCHAR(50) NOT NULL,
  tipo_pago ENUM('Deducible','Reparación','Pérdida total'),
  estado ENUM('Rechazado','Aceptado','Aceptado con deducible','Aceptado sin deducible','Pago reparación','Pérdida total'),
  fecha_aprobacion DATETIME,
  fecha_finalizacion DATETIME,
  FOREIGN KEY (id_ajustador) REFERENCES Usuarios(id_usuario),
  FOREIGN KEY (id_supervisor) REFERENCES Usuarios(id_usuario),
  FOREIGN KEY (id_unidad) REFERENCES Unidades(id_unidad)
);

CREATE TABLE Multimedia_Siniestro (
  id_multimedia INT AUTO_INCREMENT PRIMARY KEY,
  id_siniestro INT NOT NULL,
  tipo_archivo ENUM('Foto','Video') NOT NULL,
  url_archivo VARCHAR(255) NOT NULL,
  descripcion VARCHAR(255),
  fecha_subida DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_siniestro) REFERENCES Siniestros(id_siniestro)
);

CREATE TABLE Seguimiento (
  id_seguimiento INT AUTO_INCREMENT PRIMARY KEY,
  id_siniestro INT NOT NULL,
  id_usuario INT NOT NULL,
  comentario TEXT,
  fecha_comentario DATETIME DEFAULT CURRENT_TIMESTAMP,
  respuesta TEXT,
  fecha_respuesta DATETIME,
  FOREIGN KEY (id_siniestro) REFERENCES Siniestros(id_siniestro),
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

CREATE TABLE Consultas (
  id_consulta INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE NOT NULL,
  criterio_busqueda VARCHAR(100),
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);
