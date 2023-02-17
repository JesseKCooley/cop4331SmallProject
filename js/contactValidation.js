const validation2 = new JustValidate("#contact");

validation2
    .addField("#firstName"[{rule: "required"}])
    .onSuccess((event) => {
        document.getElementById("contact").submit();
    });