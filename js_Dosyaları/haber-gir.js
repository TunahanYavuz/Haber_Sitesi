const fileInput = document.getElementById('fileInput');
document.getElementById('fileInputKF').addEventListener("change", kapakFoto);
document.getElementById("haberTuru").addEventListener("change", fotoYazi);
document.addEventListener("DOMContentLoaded", updateIndexes);
document.addEventListener("DOMContentLoaded", fotoYazi);
let haberGuncelleID;
document.addEventListener("DOMContentLoaded",()=>{
    haberGuncelleID = document.querySelector("form").action;
    const updateButton = document.getElementById("updateButton");
    if (!updateButton) return
    updateButton.addEventListener("click", (e)=>{
        e.preventDefault();
        form.action = haberGuncelleID;
        if (!document.getElementById("KapakFotoDiv")){
            alert("Kapak Fotoğrafı Olmak Zorundadır.");
            return
        }
        if (!document.getElementById("HaberFoto0")){
            alert("En az bir haber fotoğrafı gerekmektedir.");
            return;
        }
        if (!qeChance(e)){
            qeChance(e)
            alert("Boş metin kutusu olamaz.");
            return;
        }
        form.requestSubmit();
        document.querySelector("#inputs").remove();
        const inputs = document.createElement("span");
        inputs.id = "inputs";
        form.appendChild(inputs)
    })
    const deleteButtons = document.querySelectorAll(".delete-button");
    deleteButtons.forEach(e => e.addEventListener("click", ()=>{
        e.parentElement.remove();
        updateIndexes();
    }))
})

let quillEditors = [];

fileInput.addEventListener('change', (event)=> {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        // Ana kapsayıcı div
        const newDiv = document.createElement('div');
        newDiv.classList.add('image-container');
        newDiv.draggable = true;
        drag(newDiv);
        // Görsel
        const newImg = document.createElement('img');
        newImg.classList.add('preview-image');

        // Quill editörü için container
        const editorDiv = document.createElement('div');
        editorDiv.id = "editor";
        editorDiv.classList.add('quill-editor');

        // Sil butonu
        const newDeleteButton = document.createElement('button');
        newDeleteButton.innerHTML = '×';
        newDeleteButton.title = 'Fotoğrafı Sil';
        newDeleteButton.classList.add('delete-button');

        const hidden_input = document.createElement("input");
        hidden_input.id = "HaberFoto";
        hidden_input.name = "HaberFoto[]";
        hidden_input.hidden = true;

        const number = document.createElement("span");
        number.classList.add("number");
        // Yapıya ekle
        newDiv.appendChild(newDeleteButton);
        newDiv.appendChild(newImg);
        newDiv.appendChild(editorDiv);
        newDiv.appendChild(hidden_input)
        newDiv.appendChild(number);
        document.getElementById('preview').appendChild(newDiv);

        const reader = new FileReader();
        reader.onload = function (e) {
            newImg.src = e.target.result;
            hidden_input.value = e.target.result;
        };
        reader.readAsDataURL(file);

        // Silme fonksiyonu
        newDeleteButton.addEventListener('click', ()=> {
            newDiv.remove();
            updateIndexes();
        });


        updateIndexes();

        fileInput.value = ''; // Input alanını temizle
    }
});
let dragged;

function drag(container){
    container.addEventListener('dragstart', (e) =>{
        if (e.target.closest('.ql-editor')) return
        dragged = container;
        e.dataTransfer.effectAllowed = 'move';

    })
    container.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        container.classList.add('drag-over');
    })
    container.addEventListener('dragleave', ()=>{
        container.classList.remove('drag-over');
    })
    container.addEventListener('drop', e => {
        e.preventDefault();
        container.classList.remove('drag-over');

        if (dragged === container) return;

        // Farenin x konumu ve hedefin sol kenarı
        const rect = container.getBoundingClientRect();
        const mouseX = e.clientX;

        const hedefinOrtasi = rect.left + rect.width / 2;

        if (mouseX < hedefinOrtasi) {
            // Soluna gelmişse: hedefin ÖNÜNE ekle
            container.parentElement.insertBefore(dragged, container);
        } else {
            // Sağına gelmişse: hedefin SONRASINA ekle
            container.parentElement.insertBefore(dragged, container.nextSibling);
        }

        updateIndexes(); // ID güncelle
    });
}
document.addEventListener("DOMContentLoaded", ()=>{
    document.querySelectorAll(".image-container").forEach(container => {
        drag(container);
    })
})

// İndeksleri yeniden düzenleyen fonksiyon
function updateIndexes() {
    quillEditors = [];
    const imageContainers = document.querySelectorAll('.image-container');
    let newIndex = 0;
    for (const container of imageContainers) {

        const newId = newIndex;

        const editor = container.querySelector('.quill-editor');
        editor.id = "editor" + newId;

        const toolbar = container.querySelector(".ql-toolbar");
        if (toolbar) toolbar.remove();
        const number = document.getElementsByClassName("number");
        number[newIndex].innerHTML = newIndex;
        const hiddenInput = container.querySelector('input[name="HaberFoto[]"]');
        hiddenInput.id = "HaberFoto" + newId;
        const quill = new Quill(`#editor${newId}`, {
            theme: 'snow',
            placeholder: 'Fotoğraf açıklaması girin...',
            bounds: `#editor${newId}`,
            modules: {
                toolbar: [
                    [{ 'font': [] }, { 'size': [] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video', 'formula'],
                    ['clean'] // tüm biçimlendirmeyi temizle
                ],
                history: {
                    delay: 1000,
                    maxStack: 100,
                    userOnly: true
                }
            }
        });
        quillEditors.push(quill);
        newIndex++;
    }
}
function kapakFoto (event){
    if (document.getElementById("KapakFotoDiv")){
        document.getElementById("KapakFotoDiv").remove();
    }
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        // Ana kapsayıcı div
        const kapakFotoPreview = document.querySelector(".kapakFotoPreview");
        const newDiv = document.createElement("div");
        const newDiv2 = document.createElement("div");
        newDiv2.classList.add("div-2");
        newDiv2.id = "div2";
        newDiv.classList.add('KFimage-container');
        newDiv.id = "KapakFotoDiv";
        // Görsel
        const newImg = document.createElement('img');
        newImg.classList.add('KFpreview-image');
        const hidden_input = document.createElement("input");
        hidden_input.id = "KapakFoto";
        hidden_input.name = "KapakFoto";
        hidden_input.hidden = true;

        // Sil butonu
        const newDeleteButton = document.createElement('button');
        newDeleteButton.innerHTML = '×';
        newDeleteButton.title = 'Fotoğrafı Sil';
        newDeleteButton.classList.add('delete-button');
        // Yapıya ekle
        newDiv.appendChild(newDeleteButton);
        newDiv.appendChild(newDiv2);
        newDiv.appendChild(hidden_input);
        newDiv2.appendChild(newImg);
        kapakFotoPreview.appendChild(newDiv);

        // Görseli yükle
        const reader = new FileReader();
        reader.onload = function (e) {
            newImg.src = e.target.result;
            hidden_input.value = e.target.result;
        };
        reader.readAsDataURL(file);

        // Silme fonksiyonu
        newDeleteButton.addEventListener('click', ()=> {
            newDiv.remove();
        });
        fotoYazi();
        fileInput.value = '';
    }
}
function fotoYazi(){
    if (parseInt(document.getElementById("haberTuru").value)===0&&document.getElementById("div2")){
        const div2 = document.getElementById("div2");
        if (document.getElementById("title-container")) div2.removeChild(document.getElementById("title-container"));
        const titleContainer = document.createElement("span");
        titleContainer.classList.add("title-container");
        titleContainer.id="title-container";
        const top = document.createElement("span");
        top.classList.add("title-top");
        top.innerText = "";
        top.innerText = document.getElementById("Ust-Yazi").value;
        const bottom = document.createElement("span");
        bottom.innerHTML = "";
        bottom.innerHTML = document.getElementById("Alt-Yazi").value;
        bottom.classList.add("title-bottom");
        const cizgi = document.createElement("span");
        cizgi.classList.add("cizgi");
        titleContainer.appendChild(top);
        titleContainer.appendChild(bottom);
        bottom.appendChild(cizgi);
        div2.appendChild(titleContainer);
    }else if (document.getElementById("title-container")){
        document.getElementById("title-container").remove();
    }
}
const form = document.querySelector("form");

document.getElementById("haberTuru").addEventListener("change", (e) => {
    let tur = parseInt(e.target.value);
    console.log(tur)
    const turSecim = document.getElementById("turSecim");
    turSecim.innerHTML = "";
    if (tur === 0) {
        const UA = ["Ust-Yazi", "Alt-Yazi"];
        for (const yazi of UA) {
            const label = document.createElement("label");
            const input = document.createElement("input");
            input.type = "text";
            input.id = yazi;
            input.addEventListener("input", fotoYazi);
            input.name = yazi;
            let final = yazi.replace("-"," ").replace("i", "ı").replace("U","Ü");
            label.innerText = final;
            input.placeholder =  final+ "yı Giriniz";
            input.required = true;
            input.addEventListener("input", fotoYazi);
            input.addEventListener("keydown",e =>{
                if (e.key === "Enter"){
                    e.preventDefault();
                }
            })
            label.appendChild(input);
            turSecim.appendChild(label);
        }
    }
});
document.querySelectorAll("input").forEach(input=> input.addEventListener("keydown", e=>{
    if (e.key === "Enter"){
        e.preventDefault();
    }
}))
document.getElementById("haberPreview").addEventListener("click", (e)=>{
    e.preventDefault();
    form.action = "haberOnizle.php";
    if (!document.getElementById("KapakFotoDiv")){
        alert("Kapak Fotoğrafı Olmak Zorundadır.");
        return
    }
    if (!document.getElementById("HaberFoto0")){
        alert("En az bir haber fotoğrafı gerekmektedir.");
        return;
    }
    if (!qeChance(e)) {
        qeChance(e)
        alert("Boş metin kutusu olamaz.");
        return;
    }

    form.requestSubmit();
    document.querySelector("#inputs").remove();
    const inputs = document.createElement("span");
    inputs.id = "inputs";
    form.appendChild(inputs)
})
const submitButton = document.getElementById("submitButton");
if (submitButton){
    submitButton.addEventListener("click",(e)=>{

        e.preventDefault();
        form.action = "haberOlustur.php";
        if (!document.getElementById("KapakFotoDiv")){
            alert("Kapak Fotoğrafı Olmak Zorundadır.");
            return
        }
        if (!document.getElementById("HaberFoto0")){
            alert("En az bir haber fotoğrafı gerekmektedir.");
            return;
        }
        if (!qeChance(e)){
            qeChance(e)
            alert("Boş metin kutusu olamaz.");
            return;
        }
        form.requestSubmit();
        document.querySelector("#inputs").remove();
        const inputs = document.createElement("span");
        inputs.id = "inputs";
        form.appendChild(inputs)
    })
}
function qeChance(e){
    e.preventDefault();
    let isValid = true;
    quillEditors.forEach((editor, i) => {
        isValid = true;
        if (editor) {
            const input = document.createElement("input");
            document.querySelector("#inputs").appendChild(input);
            input.type = "hidden";
            input.name = "icerik[]";
            input.id = "quill_" + i;
            input.value = editor.root.innerHTML;
            input.value = input.value.trim();
            if (input.value === "<p><br></p>"){
                isValid =  false;
            }
        }
    })
    return isValid;
}