<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="<?= PATH ?>/public/js/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.4.2/tinymce.min.js" integrity="sha512-SPCExIkjTrrcv8Jfu4dzvDJfMe7A9CKmKE8v1fd+Ku3Dq5B9w8rfmrAHfz2RKU+4zOyT1JlprGA1bC2o8Z1yZA==" crossorigin="anonymous"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="<?= PATH ?>/public/js/compressor.min.js"></script>
<script src="<?= PATH ?>/public/js/main.js"></script>
<script src="<?= PATH ?>/public/js/sidebar.js"></script>
<script type="module">
    import PristineForm from "/public/js/pristine-form.js"
    const form = document.getElementById('postCreate')
    console.log(form)
    if (form) {
        const postForm = new PristineForm(form, {
            rules: {
                titulo: {
                    required: true
                },
                texto: {
                    required: true
                },
                'tags[]': {
                    required: true
                },
                'categorias[]': {
                    required: true
                }
            },
            onSubmit: async function (form) {
                const data = new FormData(form)
                
                const response = await axios.post(form.action, data)
                if (response.code === 200) {
                    window.location.href = window.location.origin + 'post/myPosts'
                }
            }
        })
    }
</script>
<script>
    (function () {
        function getResults(page = 1) {
            const resultsDiv = document.getElementById('results')
            if (resultsDiv) {
                const data = new FormData()
                data.append('json', true)
                data.append('p', page)
                axios.post('', data).then((result) => {
                    resultsDiv.innerHTML = ''
                    result.data.Posts.forEach(p => {
                        resultsDiv.insertAdjacentHTML(
                            'beforeend',
                            `<div class="col-md-3">
                        <a href="post/${p.Id}">
                            <img src="public/img/posts/${p.Capa}" alt="" class="w-full rounded hover:shadow-lg
                            transition-shadow duration-300">
                            <span class="text-lg text-center text-gray-900 block">${p.Titulo}</span>
                        </a>
                    </div>`
                        )
                    })
                })
            }
        }

        getResults()

        document.querySelectorAll('.pagination-link').forEach(btn => {
            btn.addEventListener('click', evt => {
                evt.preventDefault()
                const activeClass = "bg-blue-500 hover:bg-blue-600 text-white"
                const inactiveClass = "bg-gray-100 hover:bg-gray-300 text-gray-700"

                getResults(btn.dataset.page)

                const activeLink = document.querySelector(`.pagination-link.${activeClass.replace(' ', '.')}`)
                activeLink.classList.remove(activeClass)
                activeLink.classList.add(inactiveClass)
                btn.classList.remove(inactiveClass)
                btn.classList.add(activeClass)
            })
        })

    })()
</script>
</body>
</html>