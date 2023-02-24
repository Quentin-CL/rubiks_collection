let container = document.querySelector(".tabs");
let buttons = container.querySelectorAll(".tabs__button");

for (const button of buttons) {
    if (button.getAttribute("aria-selected") === "true") {
        const position = [...buttons].indexOf(button);
        container.style.setProperty("--background-offset", position * 100 + "%");
        container.style.setProperty("--background-offset-padding", (position - 1) * 6 + "px");
    }
}


buttons.forEach((btn) => {
    btn.addEventListener("click", (event) => {
        switchActive(btn);
    });
});

function switchActive(activeBtn) {
    const position = [...buttons].indexOf(activeBtn);

    buttons.forEach((element) => {
        element.setAttribute(
            "aria-selected",
            element !== activeBtn ? "false" : "true"
        );
    });

    container.style.setProperty("--background-offset", position * 100 + "%");
    container.style.setProperty("--background-offset-padding", (position - 1) * 6 + "px");
}
