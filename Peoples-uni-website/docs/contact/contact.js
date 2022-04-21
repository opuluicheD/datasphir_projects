document.querySelector(".contact-form").addEventListener("submit", submitForm);

function submitForm(e) {
	e.preventDefault();

	let name = document.querySelector(".name").value;
	let email = document.querySelector(".email").value;
	let subject = document.querySelector(".subject").value;
	let message = document.querySelector(".message").value;

	// document.querySelector(".contact-form").reset();

	sendMail(name, email, subject, message);
	document.querySelector(".contact-form").reset();
}

function sendMail(name, email, subject, message) {
	Email.send({
		SecureToken: "3ba0870c-ceae-41fa-826d-ae803ff702a8",
		To: "shadowshadon@gmail.com",
		From: `${email}`,
		Subject: `${subject}`,
		Body: `${name} <br /> Message: ${message}`,
	}).then((message) => alert("mail sent successfully"));
}
// smtp.elasticemail.com;
// D553146008C9614CECC40586EF348F3E5C2C;
