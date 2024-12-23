<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    .email-container {
      max-width: 600px;
      margin: 20px auto;
      background-color: #ffffff;
      border: 1px solid #dddddd;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .header {
      text-align: center;
      font-size: 24px;
      color: #333333;
      margin-bottom: 20px;
    }

    .data-row {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid #eeeeee;
    }

    .data-row:last-child {
      border-bottom: none;
    }

    .label {
      font-weight: bold;
      color: #555555;
    }

    .value {
      color: #333333;
    }
  </style>
</head>

<body>
  <div class="email-container">
    <div class="header">Contact Form Submission</div>
    <div class="data-row">
      <div class="label">First Name:</div>
      <div class="value">{{ $firstNameValue }}</div>
    </div>
    <div class="data-row">
      <div class="label">Last Name:</div>
      <div class="value">{{ $lastNameValue }}</div>
    </div>
    <div class="data-row">
      <div class="label">Email:</div>
      <div class="value">{{ $emailValue }}</div>
    </div>
    <div class="data-row">
      <div class="label">Subject:</div>
      <div class="value">{{ $subjectValue }}</div>
    </div>
    <div class="data-row">
      <div class="label">Message:</div>
      <div class="value">{{ $messageValue }}</div>
    </div>
  </div>
</body>

</html>
