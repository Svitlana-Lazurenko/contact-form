document.addEventListener("DOMContentLoaded", () => {
  const customForm = document.querySelector(".form");
  const inputs = document.querySelectorAll(".form__control");
  const phoneInput = document.querySelector(".form__control--phone");
  const inputMessages = document.querySelectorAll(".form__error");
  const submitButton = document.querySelector(".btn");
  const submitButtonText = document.querySelector(".btn__text");
  const spinner = document.querySelector(".spinner");
  const modal = document.querySelector(".modal");
  const closeButton = modal.querySelector(".close-btn");
  const iti = initializeIntlTelInput(phoneInput);

  function getUTMParams() {
    const urlParams = new URLSearchParams(window.location.search);
    return {
      utm_source: urlParams.get("utm_source") || "",
      utm_medium: urlParams.get("utm_medium") || "",
      utm_campaign: urlParams.get("utm_campaign") || "",
      utm_term: urlParams.get("utm_term") || "",
      utm_content: urlParams.get("utm_content") || "",
    };
  }

  function cleanInputs() {
    inputs.forEach((input) => {
      input.classList.remove("is-error");
    });
    inputMessages.forEach((inputMessage) => {
      inputMessage.textContent = "";
    });
  }

  customForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(customForm);
    formData.set("phone", iti.getNumber());
    const utmParams = getUTMParams();
    for (const [key, value] of Object.entries(utmParams)) {
      formData.append(key, value);
    }
    formData.append("form_date", new Date());
    formData.append("action", "custom_contact_form");
    formData.append("nonce", ajax_object.nonce);

    submitButton.disabled = true;
    submitButtonText.textContent = "Надсилається...";
    spinner.classList.add("is-visible");

    fetch(ajax_object.ajax_url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          cleanInputs();
          customForm.reset();
          openModal(modal);
        } else {
          cleanInputs();
          const erroredInput = customForm.querySelector(
            `[name="${data.data.name}"]`
          );
          const erroredInputMessage = customForm.querySelector(
            `.form__error--${data.data.name}`
          );
          if (erroredInput && erroredInputMessage) {
            erroredInput.classList.add("is-error");
            erroredInputMessage.textContent = data.data.message;
          } else {
            console.log(data.data.message);
          }
        }
      })
      .catch((error) => {
        console.log(error.message);
      })
      .finally(() => {
        submitButton.disabled = false;
        submitButtonText.textContent = "Надіслати";
        spinner.classList.remove("is-visible");
      });

    setupModalEvents(modal, closeButton);
  });
});
