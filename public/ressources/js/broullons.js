document.addEventListener("DOMContentLoaded", () => {
    // let modalViews = document.querySelectorAll(".modalView");
    let publier = document.querySelectorAll(".publier");
    // modalViews.forEach(mod => {
    //     mod.addEventListener("click", () => {
    //         // Marcos, touche pas à ce bout de code. Tu peux complèter pour toi mais ne supprime pas ce que j'ai fait là
    //         let data = {
    //             id: mob.value,
    //         }
    //         data = JSON.stringify(data);
    //         let option = {
    //             header: {
    //                 content: "application/json"
    //             },
    //             body: data,
    //             method: "post"
    //         }
    //     })
    // })
    
    publier.forEach(pub => {
        pub.addEventListener("click", () => {
            let parent = pub.parentElement.parentElement.parentElement;
            let data = {
                id: pub.value,
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=article-controller&action=update-state", option)
            parent.remove();
        })
    })
})