const express = require('express');
const router = express.Router();
const xlsx = require('xlsx');
const readXlsxFile = require('read-excel-file/node');
const db = require('./db');
const bcrypt = require('bcrypt');
const nodemailer = require('nodemailer');
const crypto = require('crypto');


router.post('/guardar_coordenadas', (req, res) => {
  console.log("Solicitud recibida:", req.body);
  const { latitude, longitude } = req.body;

  if (!latitude || !longitude) {
    return res.status(400).json({ message: 'Faltan coordenadas' });
  }

  const query = 'INSERT INTO coordenadas (latitude, longitude) VALUES (?, ?)';
  db.query(query, [latitude, longitude], (err, result) => {
    if (err) {
      console.error('Error al guardar las coordenadas:', err);
      return res.status(500).json({ message: 'Error al guardar las coordenadas' });
    }
    res.status(200).json({ message: 'Coordenadas guardadas correctamente' });
  });
});

// Ruta para obtener todos los usuarios
router.get('/usuarios', (req, res) => {
  connection.query('SELECT * FROM usuarios', (err, results) => {
    if (err) {
      console.error('Error al obtener registros:', err);
      return res.status(500).json({ error: 'Error al obtener registros' });
    }
    res.json(results);
  });
});

// Ruta para obtener un usuario por su ID
router.get('/usuarios/:id_usuario', (req, res) => {
  const id = req.params.id_usuario;
  connection.query('SELECT * FROM usuarios WHERE id = ?', [id], (err, results) => {
    if (err) {
      console.error('Error al obtener el registro:', err);
      return res.status(500).json({ error: 'Error al obtener el registro' });
    }
    if (results.length === 0) {
      return res.status(404).json({ error: 'Usuario no encontrado' });
    }
    res.json(results[0]);
  });
});

router.post('/usuarios', async (req, res) => {
  const { nombre, apellido_paterno, apellido_materno, correo, PASSWORD, matricula, fecha_nacimiento, sexo, activo, rol } = req.body;

  // Validar que todos los campos estén presentes
  if (!nombre || !apellido_paterno || !apellido_materno || !correo || !PASSWORD || !matricula || !fecha_nacimiento || !sexo || activo === undefined || !rol) {
    return res.status(400).json({ error: 'Todos los campos son obligatorios' });
  }

  try {
    // Encriptar la contraseña
    const salt = await bcrypt.genSalt(10);  // Generar un "sal" con 10 rondas
    const hashedPassword = await bcrypt.hash(PASSWORD, salt);  // Encriptar la contraseña

    // Consulta para obtener el id del rol según el nombre del rol
    const getRoleIdQuery = `SELECT id FROM roles WHERE nombre = ?`;
    connection.query(getRoleIdQuery, [rol], (err, result) => {
      if (err) {
        console.error('Error al obtener el id del rol:', err);
        return res.status(500).json({ error: 'Error al obtener el id del rol' });
      }

      if (result.length === 0) {
        return res.status(400).json({ error: 'Rol no encontrado' });
      }

      const rolId = result[0].id;

      // Consulta para insertar el nuevo usuario, incluyendo el rol
      const query = `INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, correo, PASSWORD, matricula, fecha_nacimiento, sexo, activo, rol_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`;

      connection.query(query, [nombre, apellido_paterno, apellido_materno, correo, hashedPassword, matricula, fecha_nacimiento, sexo, activo, rolId], (err, result) => {
        if (err) {
          console.error('Error al insertar datos:', err);
          return res.status(500).json({ error: 'Error al insertar datos en la base de datos' });
        }
        res.status(201).json({ message: 'Usuario registrado exitosamente', id: result.insertId });
      });
    });
  } catch (error) {
    console.error('Error al encriptar la contraseña:', error);
    res.status(500).json({ error: 'Error al encriptar la contraseña' });
  }
});


// Ruta para actualizar un usuario por ID
router.put('/usuarios/:id_usuario', (req, res) => {
  const { id_usuario } = req.params;
  const { nombre, apellido_paterno, apellido_materno, correo, PASSWORD, matricula, fecha_nacimiento, sexo, activo } = req.body;

  if (!nombre || !apellido_paterno || !apellido_materno || !correo || !PASSWORD || !matricula || !fecha_nacimiento || !sexo || activo === undefined) {
    return res.status(400).json({ error: 'Todos los campos son obligatorios' });
  }

  // Encriptar la nueva contraseña
  bcrypt.genSalt(10, (err, salt) => {
    if (err) {
      return res.status(500).json({ error: 'Error al generar el sal' });
    }

    bcrypt.hash(PASSWORD, salt, (err, hashedPassword) => {
      if (err) {
        return res.status(500).json({ error: 'Error al encriptar la contraseña' });
      }

      const query = `UPDATE usuarios SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, correo = ?, PASSWORD = ?, matricula = ?, 
                     fecha_nacimiento = ?, sexo = ?, activo = ? WHERE id = ?`;

      connection.query(query, [nombre, apellido_paterno, apellido_materno, correo, hashedPassword, matricula, fecha_nacimiento, sexo, activo, id_usuario], (err, result) => {
        if (err) {
          console.error('Error al actualizar datos:', err);
          return res.status(500).json({ error: 'Error al actualizar datos en la base de datos' });
        }

        if (result.affectedRows === 0) {
          return res.status(404).json({ error: 'Usuario no encontrado' });
        }

        res.json({ message: 'Usuario actualizado correctamente' });
      });
    });
  });
});

// Ruta para eliminar un usuario por ID
router.delete('/usuarios/:id_usuario', (req, res) => {
  const { id_usuario } = req.params;

  const query = `DELETE FROM usuarios WHERE id = ?`;

  connection.query(query, [id_usuario], (err, result) => {
    if (err) {
      console.error('Error al eliminar el usuario:', err);
      return res.status(500).json({ error: 'Error al eliminar el usuario en la base de datos' });
    }

    if (result.affectedRows === 0) {
      return res.status(404).json({ error: 'Usuario no encontrado' });
    }

    res.json({ message: 'Usuario eliminado correctamente' });
  });
});

// Ruta para login
router.post('/login', (req, res) => {
  const { correo, PASSWORD } = req.body;
  console.log(req.body);  // Ver qué llega al servidor

  if (!correo || !PASSWORD) {
    return res.status(400).json({ error: 'Correo y contraseña son requeridos' });
  }

  // Buscar al usuario por correo
  const query = 'SELECT * FROM usuarios WHERE correo = ?';
  connection.query(query, [correo], async (err, results) => {
    if (err) {
      console.error('Error al obtener el usuario:', err);
      return res.status(500).json({ error: 'Error al obtener el usuario' });
    }

    if (results.length === 0) {
      return res.status(404).json({ error: 'Usuario no encontrado' });
    }

    const usuario = results[0];

    // Verificar si el usuario está bloqueado
    if (usuario.locked_until && new Date(usuario.locked_until) > new Date()) {
      return res.status(403).json({ error: 'Tu cuenta está bloqueada temporalmente. Intenta nuevamente más tarde.' });
    }

    try {
      // Comparar la contraseña ingresada con la encriptada en la base de datos
      const isMatch = await bcrypt.compare(PASSWORD, usuario.PASSWORD);

      if (isMatch) {
        // Si la contraseña es correcta, resetear los intentos fallidos y bloquear hasta NULL
        connection.query('UPDATE usuarios SET failed_attempts = 0, locked_until = NULL WHERE id = ?', [usuario.id]);

        return res.json({ message: 'Login exitoso' });
      } else {
        // Si la contraseña es incorrecta, incrementar el contador de intentos fallidos
        let failedAttempts = usuario.failed_attempts + 5;

        let lockedUntil = null;
        if (failedAttempts >= 3) {
          // Bloquear al usuario por 1 minuto si hay 3 intentos fallidos
          lockedUntil = new Date();
          lockedUntil.setMinutes(lockedUntil.getMinutes() + 1);  // Bloquear por 1 minuto
        }

        // Actualizar los intentos fallidos y el tiempo de bloqueo
        connection.query(
          'UPDATE usuarios SET failed_attempts = ?, locked_until = ? WHERE id = ?',
          [failedAttempts, lockedUntil, usuario.id]
        );

        return res.status(400).json({ error: 'Contraseña incorrecta' });
      }
    } catch (error) {
      console.error('Error al comparar las contraseñas:', error);
      res.status(500).json({ error: 'Error al comparar las contraseñas' });
    }
  });
});
















router.post('/forgot-password', (req, res) => {
  const { correo } = req.body;

  // Verificar que el correo esté en la base de datos
  const query = 'SELECT * FROM usuarios WHERE correo = ?';
  connection.query(query, [correo], (err, results) => {
    if (err) {
      console.error('Error al obtener el usuario:', err);
      return res.status(500).json({ error: 'Error al obtener el usuario' });
    }

    if (results.length === 0) {
      return res.status(404).json({ error: 'Usuario no encontrado' });
    }

    const usuario = results[0];

    // Generar un código de 6 dígitos
    const resetCode = Math.floor(100000 + Math.random() * 900000); // Código de 6 dígitos
    const resetCodeExpiry = Date.now() + 300000; // Código válido por 5 minutos (300000 ms)

    // Guardar el código y su fecha de expiración en la base de datos
    connection.query(
      'UPDATE usuarios SET reset_code = ?, reset_code_expiry = ? WHERE id = ?',
      [resetCode, resetCodeExpiry, usuario.id],
      (err, result) => {
        if (err) {
          console.error('Error al actualizar el código:', err);
          return res.status(500).json({ error: 'Error al actualizar el código' });
        }

        // Configuración de nodemailer para enviar el correo
        const transporter = nodemailer.createTransport({
          service: 'gmail',  // Usando Gmail
          auth: {
            user: 'al222310566@gmail.com', // Tu correo de Gmail
            pass: 'enbm iues uscs rutv', // Tu contraseña o una contraseña de aplicación
          },
        });

        // Enviar el correo
        const mailOptions = {
          from: 'al222310566@gmail.com',
          to: correo,  // Enviar el correo al usuario que lo pidió
          subject: 'Restablecimiento de contraseña',
          text: `Tu código de verificación es: ${resetCode}. Este código expirará en 5 minutos.`,
        };

        transporter.sendMail(mailOptions, (err, info) => {
          if (err) {
            console.error('Error al enviar el correo:', err);
            return res.status(500).json({ error: 'Error al enviar el correo' });
          }

          res.json({ message: 'Correo enviado. Revisa tu bandeja de entrada para obtener el código de verificación.' });
        });
      }
    );
  });
});

router.post('/reset-password', async (req, res) => {
  const { correo, resetCode, newPassword } = req.body;

  // Verificar el código en la base de datos
  const query = 'SELECT * FROM usuarios WHERE correo = ? AND reset_code = ? AND reset_code_expiry > ?';
  connection.query(query, [correo, resetCode, Date.now()], async (err, results) => {
    if (err) {
      console.error('Error al obtener el usuario con código:', err);
      return res.status(500).json({ error: 'Error al verificar el código' });
    }

    if (results.length === 0) {
      return res.status(400).json({ error: 'Código inválido o expirado' });
    }

    const usuario = results[0];

    // Hashear la nueva contraseña
    const hashedPassword = await bcrypt.hash(newPassword, 10);

    // Actualizar la contraseña en la base de datos
    connection.query(
      'UPDATE usuarios SET PASSWORD = ?, reset_code = NULL, reset_code_expiry = NULL WHERE id = ?',
      [hashedPassword, usuario.id],
      (err, result) => {
        if (err) {
          console.error('Error al actualizar la contraseña:', err);
          return res.status(500).json({ error: 'Error al actualizar la contraseña' });
        }

        res.json({ message: 'Contraseña actualizada exitosamente' });
      }
    );
  });
});







//--------------------------

// Obtener todos los vehiculo
router.get('/vehiculo', (req, res) => {
  connection.query('SELECT * FROM vehiculo', (err, results) => {
    if (err) {
      console.error('Error al obtener vehiculo:', err);
      res.status(500).json({ error: 'Error al obtener vehiculo' });
      return;
    }
    res.json(results);
  });
});

// Obtener un registro por su ID
router.get('/vehiculo/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM vehiculo WHERE id = ?', id, (err, results) => {
      if (err) {
        console.error('Error al obtener el registro:', err);
        res.status(500).json({ error: 'Error al obtener el registro' });
        return;
      }
      if (results.length === 0) {
        res.status(404).json({ error: 'Registro no encontrado' });
        return;
      }
      res.json(results[0]);
    });
});

// Crear un nuevo registro
router.post('/vehiculo', (req, res) => {
  const nuevoRegistro = req.body;
  connection.query('INSERT INTO vehiculo SET ?', nuevoRegistro, (err, results) => {
    if (err) {
      console.error('Error al crear un nuevo registro:', err);
      res.status(500).json({ error: 'Error al crear un nuevo registro' });
      return;
    }
    res.status(201).json({ message: 'Registro creado exitosamente' });
  });
});

// Actualizar un registro
router.put('/vehiculo/:id', (req, res) => {
  const id = req.params.id;
  const datosActualizados = req.body;
  connection.query('UPDATE vehiculo SET ? WHERE id = ?', [datosActualizados, id], (err, results) => {
    if (err) {
      console.error('Error al actualizar el registro:', err);
      res.status(500).json({ error: 'Error al actualizar el registro' });
      return;
    }
    res.json({ message: 'Registro actualizado exitosamente' });
  });
});

// Eliminar un registro
router.delete('/vehiculo/:id', (req, res) => {
  const id = req.params.id;
  connection.query('DELETE FROM vehiculo WHERE id = ?', id, (err, results) => {
    if (err) {
      console.error('Error al eliminar el registro:', err);
      res.status(500).json({ error: 'Error al eliminar el registro' });
      return;
    }
    res.json({ message: 'Registro eliminado exitosamente' });
  });
});


// Obtener todos los vehiculo de dos tablas
router.get('/datos', (req, res) => {
  connection.query('SELECT car.id_carrera AS id, car.nombre AS carrera, gru.nombre AS grupo ' +
    'FROM tb_carrera AS car, tb_grupos AS gru ' +
    'WHERE car.id_carrera=gru.id_carrera', (err, results) => {
    if (err) {
      console.error('Error al obtener registros:', err);
      res.status(500).json({ error: 'Error al obtener registros' });
      return;
    }
    res.json(results);
  });
});


/////////////////Trayectoria/////////////////////////////



// Obtener todos los trayectoria
router.get('/trayectoria', (req, res) => {
  connection.query('SELECT * FROM trayectoria', (err, results) => {
    if (err) {
      console.error('Error al obtener trayectoria:', err);
      res.status(500).json({ error: 'Error al obtener trayectoria' });
      return;
    }
    res.json(results);
  });
});

// Obtener un registro por su ID
router.get('/trayectoria/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM trayectoria WHERE id = ?', id, (err, results) => {
      if (err) {
        console.error('Error al obtener el registro:', err);
        res.status(500).json({ error: 'Error al obtener el registro' });
        return;
      }
      if (results.length === 0) {
        res.status(404).json({ error: 'Registro no encontrado' });
        return;
      }
      res.json(results[0]);
    });
});

// Crear un nuevo registro
router.post('/trayectoria', (req, res) => {
  const nuevoRegistro = req.body;
  connection.query('INSERT INTO trayectoria SET ?', nuevoRegistro, (err, results) => {
    if (err) {
      console.error('Error al crear un nuevo registro:', err);
      res.status(500).json({ error: 'Error al crear un nuevo registro' });
      return;
    }
    res.status(201).json({ message: 'Registro creado exitosamente' });
  });
});

// Actualizar un registro
router.put('/trayectoria/:id', (req, res) => {
  const id = req.params.id;
  const datosActualizados = req.body;
  connection.query('UPDATE trayectoria SET ? WHERE id = ?', [datosActualizados, id], (err, results) => {
    if (err) {
      console.error('Error al actualizar el registro:', err);
      res.status(500).json({ error: 'Error al actualizar el registro' });
      return;
    }
    res.json({ message: 'Registro actualizado exitosamente' });
  });
});

// Eliminar un registro
router.delete('/trayectoria/:id', (req, res) => {
  const id = req.params.id;
  connection.query('DELETE FROM trayectoria WHERE id = ?', id, (err, results) => {
    if (err) {
      console.error('Error al eliminar el registro:', err);
      res.status(500).json({ error: 'Error al eliminar el registro' });
      return;
    }
    res.json({ message: 'Registro eliminado exitosamente' });
  });
});


// Obtener todos los trayectoria de dos tablas
router.get('/datos', (req, res) => {
  connection.query('SELECT car.id_carrera AS id, car.nombre AS carrera, gru.nombre AS grupo ' +
    'FROM tb_carrera AS car, tb_grupos AS gru ' +
    'WHERE car.id_carrera=gru.id_carrera', (err, results) => {
    if (err) {
      console.error('Error al obtener registros:', err);
      res.status(500).json({ error: 'Error al obtener registros' });
      return;
    }
    res.json(results);
  });
});

////////////////////////////////////Sensor/////////////////////////////



// Obtener todos los sensor de dos tablas
router.get('/sensor', (req, res) => {
  connection.query('SELECT * FROM sensor', (err, results) => {
    if (err) {
      console.error('Error al obtener sensor:', err);
      res.status(500).json({ error: 'Error al obtener sensor' });
      return;
    }
    res.json(results);
  });
});

// Obtener un registro por su ID
router.get('/sensor/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM sensor WHERE id = ?', id, (err, results) => {
      if (err) {
        console.error('Error al obtener el registro:', err);
        res.status(500).json({ error: 'Error al obtener el registro' });
        return;
      }
      if (results.length === 0) {
        res.status(404).json({ error: 'Registro no encontrado' });
        return;
      }
      res.json(results[0]);
    });
});

// Crear un nuevo registro
router.post('/sensor', (req, res) => {
  const nuevoRegistro = req.body;
  connection.query('INSERT INTO sensor SET ?', nuevoRegistro, (err, results) => {
    if (err) {
      console.error('Error al crear un nuevo registro:', err);
      res.status(500).json({ error: 'Error al crear un nuevo registro' });
      return;
    }
    res.status(201).json({ message: 'Registro creado exitosamente' });
  });
});

// Actualizar un registro
router.put('/sensor/:id', (req, res) => {
  const id = req.params.id;
  const datosActualizados = req.body;
  connection.query('UPDATE sensor SET ? WHERE id = ?', [datosActualizados, id], (err, results) => {
    if (err) {
      console.error('Error al actualizar el registro:', err);
      res.status(500).json({ error: 'Error al actualizar el registro' });
      return;
    }
    res.json({ message: 'Registro actualizado exitosamente' });
  });
});

// Eliminar un registro
router.delete('/sensor/:id', (req, res) => {
  const id = req.params.id;
  connection.query('DELETE FROM sensor WHERE id = ?', id, (err, results) => {
    if (err) {
      console.error('Error al eliminar el registro:', err);
      res.status(500).json({ error: 'Error al eliminar el registro' });
      return;
    }
    res.json({ message: 'Registro eliminado exitosamente' });
  });
});

router.get('/datos', (req, res) => {
  connection.query('SELECT car.id_carrera AS id, car.nombre AS carrera, gru.nombre AS grupo ' +
    'FROM tb_carrera AS car, tb_grupos AS gru ' +
    'WHERE car.id_carrera=gru.id_carrera', (err, results) => {
    if (err) {
      console.error('Error al obtener registros:', err);
      res.status(500).json({ error: 'Error al obtener registros' });
      return;
    }
    res.json(results);
  });
});

//////////////////Mantenimiento-sensor/////////////////////////

router.get('/mantenimiento', (req, res) => {
  connection.query('SELECT * FROM mantenimiento', (err, results) => {
    if (err) {
      console.error('Error al obtener mantenimiento:', err);
      res.status(500).json({ error: 'Error al obtener mantenimiento' });
      return;
    }
    res.json(results);
  });
});

// Obtener un registro por su ID
router.get('/mantenimiento/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM mantenimiento WHERE id = ?', id, (err, results) => {
      if (err) {
        console.error('Error al obtener el registro:', err);
        res.status(500).json({ error: 'Error al obtener el registro' });
        return;
      }
      if (results.length === 0) {
        res.status(404).json({ error: 'Registro no encontrado' });
        return;
      }
      res.json(results[0]);
    });
});

// Crear un nuevo registro
router.post('/mantenimiento', (req, res) => {
  const nuevoRegistro = req.body;
  connection.query('INSERT INTO mantenimiento SET ?', nuevoRegistro, (err, results) => {
    if (err) {
      console.error('Error al crear un nuevo registro:', err);
      res.status(500).json({ error: 'Error al crear un nuevo registro' });
      return;
    }
    res.status(201).json({ message: 'Registro creado exitosamente' });
  });
});

// Actualizar un registro
router.put('/mantenimiento/:id', (req, res) => {
  const id = req.params.id;
  const datosActualizados = req.body;
  connection.query('UPDATE mantenimiento SET ? WHERE id = ?', [datosActualizados, id], (err, results) => {
    if (err) {
      console.error('Error al actualizar el registro:', err);
      res.status(500).json({ error: 'Error al actualizar el registro' });
      return;
    }
    res.json({ message: 'Registro actualizado exitosamente' });
  });
});

// Eliminar un registro
router.delete('/mantenimiento/:id', (req, res) => {
  const id = req.params.id;
  connection.query('DELETE FROM mantenimiento WHERE id = ?', id, (err, results) => {
    if (err) {
      console.error('Error al eliminar el registro:', err);
      res.status(500).json({ error: 'Error al eliminar el registro' });
      return;
    }
    res.json({ message: 'Registro eliminado exitosamente' });
  });
});


// Obtener todos los mantenimiento de dos tablas
router.get('/datos', (req, res) => {
  connection.query('SELECT car.id_carrera AS id, car.nombre AS carrera, gru.nombre AS grupo ' +
    'FROM tb_carrera AS car, tb_grupos AS gru ' +
    'WHERE car.id_carrera=gru.id_carrera', (err, results) => {
    if (err) {
      console.error('Error al obtener registros:', err);
      res.status(500).json({ error: 'Error al obtener registros' });
      return;
    }
    res.json(results);
  });
});


///////////////////detalles-trayectoria////////////////////////////////////
router.get('/detalle', (req, res) => {
  connection.query('SELECT * FROM detalle', (err, results) => {
    if (err) {
      console.error('Error al obtener detalle:', err);
      res.status(500).json({ error: 'Error al obtener detalle' });
      return;
    }
    res.json(results);
  });
});

// Obtener un registro por su ID
router.get('/detalle/:id', (req, res) => {
    const id = req.params.id;
    connection.query('SELECT * FROM detalle WHERE id = ?', id, (err, results) => {
      if (err) {
        console.error('Error al obtener el registro:', err);
        res.status(500).json({ error: 'Error al obtener el registro' });
        return;
      }
      if (results.length === 0) {
        res.status(404).json({ error: 'Registro no encontrado' });
        return;
      }
      res.json(results[0]);
    });
});

// Crear un nuevo registro
router.post('/detalle', (req, res) => {
  const nuevoRegistro = req.body;
  connection.query('INSERT INTO detalle SET ?', nuevoRegistro, (err, results) => {
    if (err) {
      console.error('Error al crear un nuevo registro:', err);
      res.status(500).json({ error: 'Error al crear un nuevo registro' });
      return;
    }
    res.status(201).json({ message: 'Registro creado exitosamente' });
  });
});

// Actualizar un registro
router.put('/detalle/:id', (req, res) => {
  const id = req.params.id;
  const datosActualizados = req.body;
  connection.query('UPDATE detalle SET ? WHERE id = ?', [datosActualizados, id], (err, results) => {
    if (err) {
      console.error('Error al actualizar el registro:', err);
      res.status(500).json({ error: 'Error al actualizar el registro' });
      return;
    }
    res.json({ message: 'Registro actualizado exitosamente' });
  });
});

// Eliminar un registro
router.delete('/detalle/:id', (req, res) => {
  const id = req.params.id;
  connection.query('DELETE FROM detalle WHERE id = ?', id, (err, results) => {
    if (err) {
      console.error('Error al eliminar el registro:', err);
      res.status(500).json({ error: 'Error al eliminar el registro' });
      return;
    }
    res.json({ message: 'Registro eliminado exitosamente' });
  });
});


////////////////////////////Excel Vehiculo////////////////////////////////

router.post('/upload-excel', (req, res) => {
  if (!req.files || !req.files.file) {
    return res.status(400).json({ error: 'No se ha proporcionado ningún archivo' });
  }

  const excelFile = req.files.file;

  // Verificar que el archivo sea un Excel
  if (!['xlsx', 'xls'].includes(excelFile.name.split('.').pop())) {
    return res.status(400).json({ error: 'El archivo debe ser un Excel (xlsx o xls)' });
  }

  // Leer el archivo Excel
  readXlsxFile(excelFile.data)
    .then((rows) => {
      // La primera fila contiene los nombres de las columnas
      const headers = rows[0];

      // Validar que las columnas esperadas estén presentes
      const expectedColumns = ['modelo', 'placas', 'anio', 'anio_alta', 'sedema', 'tarjeta_circulacion', 'usuario_id'];
      const missingColumns = expectedColumns.filter((col) => !headers.includes(col));

      if (missingColumns.length > 0) {
        return res.status(400).json({ error: `Faltan las siguientes columnas: ${missingColumns.join(', ')}` });
      }

      // Procesar las filas de datos (omitir la primera fila de encabezados)
      const data = rows.slice(1).map((row) => {
        const rowData = {};
        headers.forEach((header, index) => {
          rowData[header] = row[index];
        });
        return rowData;
      });

      // Validar que los datos no estén vacíos
      if (data.length === 0) {
        return res.status(400).json({ error: 'El archivo Excel está vacío o no tiene datos válidos' });
      }

      // Insertar los datos en la base de datos
      data.forEach((row) => {
        const { modelo, placas, anio, anio_alta, sedema, tarjeta_circulacion, usuario_id } = row;

        // Validar que todos los campos estén presentes
        if (!modelo || !placas || !anio || !anio_alta || !sedema || !tarjeta_circulacion || !usuario_id) {
          console.error('Fila inválida:', row);
          return;
        }

        // Insertar en la base de datos
        const query = 'INSERT INTO vehiculo (modelo, placas, anio, anio_alta, sedema, tarjeta_circulacion, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?)';
        connection.query(query, [modelo, placas, anio, anio_alta, sedema, tarjeta_circulacion, usuario_id], (err, result) => {
          if (err) {
            console.error('Error al insertar datos:', err);
            return;
          }
          console.log('Datos insertados correctamente:', result);
        });
      });

      res.json({ message: 'Archivo Excel procesado correctamente', data });
    })
    .catch((error) => {
      console.error('Error al leer el archivo Excel:', error);
      res.status(500).json({ error: 'Error al leer el archivo Excel' });
    });

    
});

router.post('/endpoint', (req, res) => {
  const { data } = req.body;

  if (!data || !Array.isArray(data)) {
      return res.status(400).json({ error: 'Datos inválidos o vacíos' });
  }

  console.log('Datos recibidos:', data);
  
  res.json({ message: 'Datos recibidos correctamente' });
});

//////////////////////Excel Trayectoria ///////////////////////////////

router.post('/upload-trayectoria', (req, res) => {
  if (!req.files || !req.files.file) {
    return res.status(400).json({ error: 'No se ha proporcionado ningún archivo' });
  }

  const excelFile = req.files.file;

  // Verificar que el archivo sea un Excel
  if (!['xlsx', 'xls'].includes(excelFile.name.split('.').pop())) {
    return res.status(400).json({ error: 'El archivo debe ser un Excel (xlsx o xls)' });
  }

  // Leer el archivo Excel
  readXlsxFile(excelFile.data)
    .then((rows) => {
      // La primera fila contiene los nombres de las columnas
      const headers = rows[0];

      // Validar que las columnas esperadas estén presentes
      const expectedColumns = ['hora_inicio', 'ruta_inicio', 'hora_final', 'ruta_final', 'vehiculo_id'];
      const missingColumns = expectedColumns.filter((col) => !headers.includes(col));

      if (missingColumns.length > 0) {
        return res.status(400).json({ error: `Faltan las siguientes columnas: ${missingColumns.join(', ')}` });
      }

      // Procesar las filas de datos (omitir la primera fila de encabezados)
      const data = rows.slice(1).map((row) => {
        const rowData = {};
        headers.forEach((header, index) => {
          rowData[header] = row[index];
        });
        return rowData;
      });

      // Validar que los datos no estén vacíos
      if (data.length === 0) {
        return res.status(400).json({ error: 'El archivo Excel está vacío o no tiene datos válidos' });
      }

      // Insertar los datos en la base de datos
      data.forEach((row) => {
        const { hora_inicio, ruta_inicio, hora_final, ruta_final, vehiculo_id } = row;

        // Validar que todos los campos estén presentes
        if (!hora_inicio || !ruta_inicio || !hora_final || !ruta_final || !vehiculo_id) {
          console.error('Fila inválida:', row);
          return;
        }

        // Insertar en la base de datos
        const query = 'INSERT INTO trayectoria (hora_inicio, ruta_inicio, hora_final, ruta_final, vehiculo_id) VALUES (?, ?, ?, ?, ?, ?, ?)';
        connection.query(query, [hora_inicio, ruta_inicio, hora_final, ruta_final, vehiculo_id], (err, result) => {
          if (err) {
            console.error('Error al insertar datos:', err);
            return;
          }
          console.log('Datos insertados correctamente:', result);
        });
      });

      res.json({ message: 'Archivo Excel procesado correctamente', data });
    })
    .catch((error) => {
      console.error('Error al leer el archivo Excel:', error);
      res.status(500).json({ error: 'Error al leer el archivo Excel' });
    });

    
});

router.post('/trayectoria-endpoint', (req, res) => {
  const { data } = req.body;

  if (!data || !Array.isArray(data)) {
      return res.status(400).json({ error: 'Datos inválidos o vacíos' });
  }

  console.log('Datos recibidos:', data);
  
  res.json({ message: 'Datos recibidos correctamente' });
});


/////////////////////Excel sensor////////////////////////////////////////

router.post('/upload-sensor', (req, res) => {
  if (!req.files || !req.files.file) {
    return res.status(400).json({ error: 'No se ha proporcionado ningún archivo' });
  }

  const excelFile = req.files.file;

  // Verificar que el archivo sea un Excel
  if (!['xlsx', 'xls'].includes(excelFile.name.split('.').pop())) {
    return res.status(400).json({ error: 'El archivo debe ser un Excel (xlsx o xls)' });
  }

  // Leer el archivo Excel
  readXlsxFile(excelFile.data)
    .then((rows) => {
      // La primera fila contiene los nombres de las columnas
      const headers = rows[0];

      // Validar que las columnas esperadas estén presentes
      const expectedColumns = ['latitud', 'longitud', 'altitud', 'velocidad','rumbo', 'vehiculo_id'];
      const missingColumns = expectedColumns.filter((col) => !headers.includes(col));

      if (missingColumns.length > 0) {
        return res.status(400).json({ error: `Faltan las siguientes columnas: ${missingColumns.join(', ')}` });
      }

      // Procesar las filas de datos (omitir la primera fila de encabezados)
      const data = rows.slice(1).map((row) => {
        const rowData = {};
        headers.forEach((header, index) => {
          rowData[header] = row[index];
        });
        return rowData;
      });

      // Validar que los datos no estén vacíos
      if (data.length === 0) {
        return res.status(400).json({ error: 'El archivo Excel está vacío o no tiene datos válidos' });
      }

      // Insertar los datos en la base de datos
      data.forEach((row) => {
        const { latitud, longitud, altitud, velocidad,rumbo, vehiculo_id } = row;

        // Validar que todos los campos estén presentes
        if (
          latitud === undefined || longitud === undefined || altitud === undefined ||
          velocidad === undefined || vehiculo_id === undefined
        ) {
          console.error('Fila inválida:', row);
          return;
        }        

        // Insertar en la base de datos
        const query = 'INSERT INTO sensor(latitud, longitud, altitud, velocidad, rumbo, vehiculo_id) VALUES (?, ?, ?, ?, ?, ?)';
        connection.query(query, [latitud, longitud, altitud, velocidad, rumbo, vehiculo_id], (err, result) => {

          if (err) {
            console.error('Error al insertar datos:', err);
            return;
          }
          console.log('Datos insertados correctamente:', result);
        });
      });

      res.json({ message: 'Archivo Excel procesado correctamente', data });
    })
    .catch((error) => {
      console.error('Error al leer el archivo Excel:', error);
      res.status(500).json({ error: 'Error al leer el archivo Excel' });
    });

    
});

router.post('/sensor-endpoint', (req, res) => {
  const { data } = req.body;

  if (!data || !Array.isArray(data)) {
      return res.status(400).json({ error: 'Datos inválidos o vacíos' });
  }

  console.log('Datos recibidos:', data);
  
  res.json({ message: 'Datos recibidos correctamente' });
});


/////////////////////////Excel Mantenimiento Sensor ///////////////////////////

router.post('/upload-mantenimiento', (req, res) => {
  if (!req.files || !req.files.file) {
    return res.status(400).json({ error: 'No se ha proporcionado ningún archivo' });
  }

  const excelFile = req.files.file;

  // Verificar que el archivo sea un Excel
  if (!['xlsx', 'xls'].includes(excelFile.name.split('.').pop())) {
    return res.status(400).json({ error: 'El archivo debe ser un Excel (xlsx o xls)' });
  }

  // Leer el archivo Excel
  readXlsxFile(excelFile.data)
    .then((rows) => {
      // La primera fila contiene los nombres de las columnas
      const headers = rows[0];

      // Validar que las columnas esperadas estén presentes
      const expectedColumns = ['observaciones', 'hora_fecha', 'vehiculo_id'];
      const missingColumns = expectedColumns.filter((col) => !headers.includes(col));

      if (missingColumns.length > 0) {
        return res.status(400).json({ error: `Faltan las siguientes columnas: ${missingColumns.join(', ')}` });
      }

      // Procesar las filas de datos (omitir la primera fila de encabezados)
      const data = rows.slice(1).map((row) => {
        const rowData = {};
        headers.forEach((header, index) => {
          rowData[header] = row[index];
        });
        return rowData;
      });

      // Validar que los datos no estén vacíos
      if (data.length === 0) {
        return res.status(400).json({ error: 'El archivo Excel está vacío o no tiene datos válidos' });
      }

      // Insertar los datos en la base de datos
      data.forEach((row) => {
        const { observaciones, hora_fecha, vehiculo_id } = row;

        // Validar que todos los campos estén presentes
        if (
          observaciones === undefined || hora_fecha === undefined || vehiculo_id === undefined 
        ) {
          console.error('Fila inválida:', row);
          return;
        }        

        // Insertar en la base de datos
        const query = 'INSERT INTO mantenimiento(observaciones, hora_fecha, vehiculo_id) VALUES (?, ?, ?, ?, ?, ?)';
        connection.query(query, [observaciones, hora_fecha, vehiculo_id], (err, result) => {

          if (err) {
            console.error('Error al insertar datos:', err);
            return;
          }
          console.log('Datos insertados correctamente:', result);
        });
      });

      res.json({ message: 'Archivo Excel procesado correctamente', data });
    })
    .catch((error) => {
      console.error('Error al leer el archivo Excel:', error);
      res.status(500).json({ error: 'Error al leer el archivo Excel' });
    });

    
});

router.post('/mantenimiento-endpoint', (req, res) => {
  const { data } = req.body;

  if (!data || !Array.isArray(data)) {
      return res.status(400).json({ error: 'Datos inválidos o vacíos' });
  }

  console.log('Datos recibidos:', data);
  
  res.json({ message: 'Datos recibidos correctamente' });
});


////////////////////////Detalle///////////////////
router.post('/upload-detalle', (req, res) => {
  if (!req.files || !req.files.file) {
    return res.status(400).json({ error: 'No se ha proporcionado ningún archivo' });
  }

  const excelFile = req.files.file;

  // Verificar que el archivo sea un Excel
  if (!['xlsx', 'xls'].includes(excelFile.name.split('.').pop())) {
    return res.status(400).json({ error: 'El archivo debe ser un Excel (xlsx o xls)' });
  }

  // Leer el archivo Excel
  readXlsxFile(excelFile.data)
    .then((rows) => {
      // La primera fila contiene los nombres de las columnas
      const headers = rows[0];

      // Validar que las columnas esperadas estén presentes
      const expectedColumns = ['latitud', 'longitud', 'altitud', 'descripcion', 'foto', 'nombre_encuentro', 'hora_aproximada', 'trayectoria_id'];
      const missingColumns = expectedColumns.filter((col) => !headers.includes(col));

      if (missingColumns.length > 0) {
        return res.status(400).json({ error: `Faltan las siguientes columnas: ${missingColumns.join(', ')}` });
      }

      // Procesar las filas de datos (omitir la primera fila de encabezados)
      const data = rows.slice(1).map((row) => {
        const rowData = {};
        headers.forEach((header, index) => {
          rowData[header] = row[index];
        });
        return rowData;
      });

      // Validar que los datos no estén vacíos
      if (data.length === 0) {
        return res.status(400).json({ error: 'El archivo Excel está vacío o no tiene datos válidos' });
      }

      // Insertar los datos en la base de datos
      data.forEach((row) => {
        const {latitud, longitud, altitud, descripcion, foto, nombre_encuentro, hora_aproximada, trayectoria_id } = row;

        // Validar que todos los campos estén presentes
        if (!latitud || !longitud || !altitud || !descripcion || !nombre_encuentro || !hora_aproximada || !trayectoria_id) {
          console.error('Fila inválida:', row);
          return;
        }

        // Insertar en la base de datos
        const query = 'INSERT INTO detalle ( latitud, longitud, altitud, descripcion, foto, nombre_encuentro, hora_aproximada, trayectoria_id) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)';
        connection.query(query, [latitud, longitud, altitud, descripcion, foto, nombre_encuentro, hora_aproximada, trayectoria_id], (err, result) => {
          if (err) {
            console.error('Error al insertar datos:', err);
            return;
          }
          console.log('Datos insertados correctamente:', result);
        });
      });

      res.json({ message: 'Archivo Excel procesado correctamente', data });
    })
    .catch((error) => {
      console.error('Error al leer el archivo Excel:', error);
      res.status(500).json({ error: 'Error al leer el archivo Excel' });
    });
});

router.post('/detalle-endpoint', (req, res) => {
  const { data } = req.body;

  if (!data || !Array.isArray(data)) {
      return res.status(400).json({ error: 'Datos inválidos o vacíos' });
  }

  console.log('Datos recibidos:', data);
  
  res.json({ message: 'Datos recibidos correctamente' });
});


module.exports = router;


