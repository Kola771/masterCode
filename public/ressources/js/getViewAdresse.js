let adresse_view_ip = document.getElementById("adresse_view_ip").value;
let data = {
    adresse: adresse_view_ip
};
data = JSON.stringify(data);
let option = {
    header: {
        content: "application/json"
    },
    body: data,
    method: "post"
};
let url = window.location.href.split("&")[1];
fetch("?ajax=view-adresse-controller&action=add-view&" + url, option);