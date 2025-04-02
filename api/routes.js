const express = require('express');
const router = express.Router();
const connection = require('./db');
const bcrypt = require('bcrypt');


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

// Ruta para insertar un nuevo usuario
router.post('/usuarios', async (req, res) => {
  const { nombre, apellido_paterno, apellido_materno, correo, PASSWORD, matricula, fecha_nacimiento, sexo, activo } = req.body;

  if (!nombre || !apellido_paterno || !apellido_materno || !correo || !PASSWORD || !matricula || !fecha_nacimiento || !sexo || activo === undefined) {
    return res.status(400).json({ error: 'Todos los campos son obligatorios' });
  }

  try {
    // Encriptar la contraseña
    const salt = await bcrypt.genSalt(10);  // Generar un "sal" con 10 rondas
    const hashedPassword = await bcrypt.hash(PASSWORD, salt);  // Encriptar la contraseña

    // Consulta para insertar el nuevo usuario
    const query = `INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, correo, PASSWORD, matricula, fecha_nacimiento, sexo, activo) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)`;

    connection.query(query, [nombre, apellido_paterno, apellido_materno, correo, hashedPassword, matricula, fecha_nacimiento, sexo, activo], (err, result) => {
      if (err) {
        console.error('Error al insertar datos:', err);
        return res.status(500).json({ error: 'Error al insertar datos en la base de datos' });
      }
      res.status(201).json({ message: 'Usuario registrado exitosamente', id: result.insertId });
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

    try {
      // Comparar la contraseña ingresada con la encriptada en la base de datos
      const isMatch = await bcrypt.compare(PASSWORD, usuario.PASSWORD);

      if (isMatch) {
        res.json({ message: 'Login exitoso' });
      } else {
        res.status(400).json({ error: 'Contraseña incorrecta' });
      }
    } catch (error) {
      console.error('Error al comparar las contraseñas:', error);
      res.status(500).json({ error: 'Error al comparar las contraseñas' });
    }
  });
});

module.exports = router;
