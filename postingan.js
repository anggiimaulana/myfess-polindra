const form = document.querySelector(".typing-area"),
        inputField = form.querySelector(".input-field"),
        sendBtn = form.querySelector("button"),
        posting = document.querySelector(".cerita-content");

        form.onsubmit = (e) => {
            e.preventDefault();
        }

        sendBtn.onclick = () => {
            let xhr = new XMLHttpRequest(); //membuat xml objek
            xhr.open("POST", "php/insert_postingan.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if(xhr.status === 200) {
                        inputField.value = "";
                    }
                }
            }
            // send data menggunakan ajax ke php
            let formData = new FormData(form);
            xhr.send(formData);

        }


        setInterval(()=> {
            // ajax
            let xhr = new XMLHttpRequest(); //membuat xml objek
            xhr.open("POST", "php/get-postingan.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if(xhr.status === 200) {
                        let data = xhr.response;
                        posting.innerHTML = data;
                        console.log(data)
                    }
                }
            }
            // send data menggunakan ajax ke php
            let formData = new FormData(form);
            xhr.send(formData);
        }, 500);