
//pour les recherches dans un tableau
let input = document.querySelector("#searchGeneral");
let mainContain = document.querySelector(".main-contain");

document.addEventListener("DOMContentLoaded", function () {

    //au moment où on entre des caractères, la fonction myFunction() s'exécute en recherchant tout les mots comportants ces caractères
    input.addEventListener("keyup", (e) => {
        e.preventDefault();
        if(input.value.trim() !== "") {

            let data = {
                value: input.value
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=search&action=search-view", option).then(response => response.text()).then(response => {
                mainContain.innerHTML = response;
            })
        }
    })

})