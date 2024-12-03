// Função de validação do formulário de cadastro
function validateRegistrationForm() {
    let form = document.getElementById('registrationForm');
    let name = form.name.value;
    let email = form.email.value;
    let password = form.password.value;
    
    if (!name || !email || !password) {
      alert("Todos os campos são obrigatórios!");
      return false;
    }
  
    // Validação de formato de email
    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!email.match(emailPattern)) {
      alert("Por favor, insira um e-mail válido.");
      return false;
    }
  
    // Validação de senha (mínimo 6 caracteres)
    if (password.length < 6) {
      alert("A senha deve ter no mínimo 6 caracteres.");
      return false;
    }
  
    return true;
  }

  // Função para enviar dados do formulário de cadastro
  function sendRegistrationData(event) {
    event.preventDefault(); // Impede o envio tradicional do formulário
  
    if (!validateRegistrationForm()) {
      return; // Se a validação falhar, não envia os dados
    }
  
    let form = document.getElementById('registrationForm');
    let data = {
      name: form.name.value,
      email: form.email.value,
      password: form.password.value,
      age: form.age.value,
      sex: form.sex.value,
      height: form.height.value,
      weight: form.weight.value,
      goal: form.goal.value,
    };
  
    // Exibe mensagem de carregamento
    document.getElementById('loadingMessage').style.display = 'block';
  
    fetch('/api/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
      document.getElementById('loadingMessage').style.display = 'none'; // Esconde mensagem de carregamento
      if (data.success) {
        alert("Cadastro realizado com sucesso!");
        window.location.href = '/login'; // Redireciona para a página de login
      } else {
        alert("Erro ao realizar cadastro. Tente novamente.");
      }
    })
    .catch(error => {
      document.getElementById('loadingMessage').style.display = 'none'; // Esconde mensagem de carregamento
      alert("Erro de conexão. Tente novamente.");
    });
  }
  

  function showContactForm(teacherId) {
    // Preenche os dados do formulário com base na escolha do personal trainer
    let form = document.getElementById('contactForm');
    fetch(`/api/teacher/${teacherId}`)
      .then(response => response.json())
      .then(data => {
        form.subject.value = `Contato sobre treinamento - ${data.name}`;
        form.teacherId.value = teacherId; // Atribui o ID do personal trainer ao formulário
        form.message.focus(); // Coloca o foco na mensagem
      })
      .catch(error => {
        alert("Erro ao carregar os dados do professor.");
      });
  }
  

  function sendMessage(event) {
    event.preventDefault(); // Impede o envio tradicional do formulário
  
    let form = document.getElementById('contactForm');
    let subject = form.subject.value;
    let message = form.message.value;
  
    if (!subject || !message) {
      alert("Por favor, preencha todos os campos.");
      return;
    }
  
    let messageData = {
      subject: subject,
      message: message,
      teacherId: form.teacherId.value, // ID do professor escolhido
    };
  
    fetch('/api/sendMessage', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(messageData)
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Mensagem enviada com sucesso!");
        form.reset(); // Reseta o formulário após o envio
      } else {
        alert("Erro ao enviar mensagem. Tente novamente.");
      }
    })
    .catch(error => {
      alert("Erro de conexão. Tente novamente.");
    });
  }  

  // Função para iniciar o pagamento
function initiatePayment() {
    let paymentData = {
      trainerId: selectedTrainerId, // ID do personal trainer
      amount: paymentAmount, // Valor a ser pago
      paymentMethod: selectedPaymentMethod // Método de pagamento escolhido
    };
  
    fetch('/api/paypal/payment', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(paymentData)
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Pagamento realizado com sucesso!");
      } else {
        alert("Erro ao realizar o pagamento. Tente novamente.");
      }
    })
    .catch(error => {
      alert("Erro de conexão com o PayPal. Tente novamente.");
    });
  }
  