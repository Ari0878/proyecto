// mailer.js
const nodemailer = require('nodemailer');

// Crear el transporte para Gmail o tu servidor de correo
const transporter = nodemailer.createTransport({
  service: 'gmail',  // Si usas Gmail, o configura tu propio SMTP
  auth: {
    user: 'al222310566@gmail.com',     // Tu correo de Gmail
    pass: 'enbm iues uscs rutv',           // Tu contraseña o una contraseña de aplicación
  },
});

// Función para enviar el correo
const sendResetPasswordEmail = (toEmail, resetLink) => {
  const mailOptions = {
    from: 'al222310566@gmail.com',          // El correo que envía el mensaje
    to: toEmail,                         // El correo destinatario
    subject: 'Restablecimiento de Contraseña',
    text: `Haz clic en el siguiente enlace para restablecer tu contraseña: ${resetLink}`,
  };

  // Enviar el correo
  transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
      console.error('Error al enviar el correo:', error);
    } else {
      console.log('Correo enviado:', info.response);
    }
  });
};

// Exportar la función para que se pueda usar en otros archivos
module.exports = { sendResetPasswordEmail };
