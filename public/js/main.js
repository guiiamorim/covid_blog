(function () {
    window.app = {
        phoneValidator: function (phone) {
            let digits = phone.match(/(\d+)/g).join("");

            if (digits.length > 11) {
                digits = digits.substring(0, 11);
            }

            if (digits.length > 10) {
                phone = digits.replace(/(\d{2})(\d{5})(\d+)/, '($1) $2-$3');
            } else if (digits.length >= 8) {
                phone = digits.replace(/(\d{2})(\d{4})(\d+)/, '($1) $2-$3');
            } else if (digits.length > 2) {
                phone = digits.replace(/(\d{2})(\d+)/, '($1) $2');
            } else {
                phone = digits.replace(/(\d+)/, '($1)');
            }

            return phone;
        },

        passwordValidator: function (password, password2) {
            if (password === undefined || password === null || password.length < 8) {
                return false;
            } else if (password2 !== undefined && password2 !== null && password != password2) {
                return false;
            }

            return true;
        },

        findCities: function (uf) {
            let citiesSelect = document.getElementById('idCidade');
            // console.log(window.location)
            $.post(`${window.location.origin}/admin/cidades/${uf}`, function (response) {
                console.log(citiesSelect)
                while (citiesSelect?.options.length) {
                    citiesSelect.remove(0)
                }
                response.forEach(city => {
                    const opt = document.createElement('option')
                    opt.appendChild(document.createTextNode(city.nome))
                    opt.value = city.id
                    citiesSelect?.appendChild(opt)
                });
            }, 'json')
        },

        changeProfilePic: function () {
            const pic = document.getElementById('foto').files[0]
            const fileReader = new FileReader()
            fileReader.onload = function () {
                const data = fileReader.result
                document.querySelector('.profile-pic').setAttribute('src', data)
            };
            fileReader.readAsDataURL(pic)
        }
    }

    const phoneInput = document.querySelector('.phone');

    phoneInput?.addEventListener('keyup', evt => {
        evt.stopPropagation();
        let phone = phoneInput.value;
        phoneInput.value = "";
        phoneInput.value = app.phoneValidator(phone);
    });

    const pswdInput = document.getElementById('senha');
    const pswdInput2 = document.getElementById('senha2');

    pswdInput?.addEventListener('focusout', evt => {
        let isValid = app.passwordValidator(pswdInput.value);
        if (isValid) {
            pswdInput.setCustomValidity("");
        } else {
            pswdInput.setCustomValidity("Sua senha deve conter pelo menos 8 dígitos.");
            pswdInput.closest('form').reportValidity();
        }
    });

    pswdInput2?.addEventListener('keyup', evt => {
        let isValid = app.passwordValidator(pswdInput.value, pswdInput2.value);
        if (isValid) {
            pswdInput2.setCustomValidity("");
        } else {
            pswdInput2.setCustomValidity("As senhas são diferentes.");
            pswdInput2.closest('form').reportValidity();
        }
    });

    pswdInput2?.addEventListener('paste', evt => {
        evt.preventDefault();
    });

    const estateSelect = document.getElementById('estado')
    estateSelect?.addEventListener('change', evt => {
        console.log(estateSelect.value)
        app.findCities(estateSelect.value)
    })

    const imgPreview = document.querySelector('.img-preview')
    const profilePicInput = document.getElementById('foto')

    imgPreview?.addEventListener('click', evt => {
        console.log(profilePicInput)
        profilePicInput.click()
    })
    profilePicInput?.addEventListener('change', evt => {
        app.changeProfilePic()
    })

    document.querySelectorAll('select.choices-select-fetch').forEach(select => {
        const items = []
        select.dataset.selected?.split(',').forEach(i => items.push(i))
        const choicesSelect = new Choices(select, {
            silent: false,
            renderChoiceLimit: -1,
            maxItemCount: -1,
            addItems: true,
            addItemFilter: null,
            removeItems: true,
            removeItemButton: true,
            editItems: false,
            duplicateItemsAllowed: false,
            delimiter: ',',
            paste: false,
            searchEnabled: true,
            searchChoices: true,
            searchFloor: 1,
            searchResultLimit: 4,
            searchFields: 'label',
            position: 'auto',
            resetScrollPosition: true,
            shouldSort: true,
            shouldSortItems: false,
            renderSelectedChoices: 'auto',
            loadingText: 'Carregando...',
            noResultsText: 'Nenhuma opção encontrada',
            noChoicesText: 'Todas as opções selecionadas',
            itemSelectText: 'Selecionar',
            addItemText: (value) => {
                return `Aperte Enter para adicionar <b>"${value}"</b>`;
            },
            maxItemText: (maxItemCount) => {
                return `Apenas ${maxItemCount} opções podem ser selecionadas`;
            },
            valueComparer: (value1, value2) => {
                console.log(value1, value2)
                return value1 === value2;
            },
            classNames: {
                containerInner: 'rounded-md border border-gray-700 w-full inline-block',
                input: 'choices-inner-input',
            },
            fuseOptions: {
                threshold: 0.3
            }
        }).setChoices(async function () {
            try {
                let choices = []
                const response = await fetch(select.dataset.choices)
                const jsonResponse = await response.json()
                console.log(jsonResponse)
                jsonResponse.Tagss.forEach(tag => {
                    if (items.indexOf(tag.Id.toString()) !== -1)
                        items[items.indexOf(tag.Id.toString())] = {'value': tag.Id, 'label': tag.Nome}
                    else
                        choices.push({'value': tag.Id, 'label': tag.Nome})
                })
                choicesSelect.then(ch => ch.setValue(items))

                return choices || []
            } catch (e) {
                console.error(e)
            }
        })

        select.addEventListener('search', evt => {
            if (evt.detail.resultCount === 0) {
                const item = select.closest('.choices').querySelector('.has-no-results')
                item.classList.add('choices__item--selectable', 'is-highlighted')
                item.dataset.selectText = 'Criar tag'
                item.addEventListener('click', evt => {
                    $.post(select.dataset.create, {element: select.parentNode.querySelector('input.choices-inner-input').value}, function (response) {
                        // console.log(choicesSelect)
                        choicesSelect.then(ch => {
                            ch.clearInput()
                            ch.setChoices([response], 'Id', 'Nome', false)
                            ch.setChoiceByValue(response.Id)
                        })
                    }, 'json')
                })
            }
        })
    })

    document.querySelectorAll('select.choices-select').forEach(select => {
        const items = []
        select.dataset.selected?.split(',').forEach(i => items.push({'value': i, 'label': select.querySelector(`option[value="${i}"]`).text}))
        const choicesSelect = new Choices(select, {
            silent: false,
            renderChoiceLimit: -1,
            maxItemCount: -1,
            addItems: true,
            addItemFilter: null,
            removeItems: true,
            removeItemButton: true,
            editItems: false,
            duplicateItemsAllowed: false,
            delimiter: ',',
            paste: false,
            searchEnabled: true,
            searchChoices: true,
            searchFloor: 1,
            searchResultLimit: 4,
            searchFields: ['label', 'value'],
            position: 'auto',
            resetScrollPosition: true,
            shouldSort: true,
            shouldSortItems: false,
            renderSelectedChoices: 'auto',
            loadingText: 'Carregando...',
            noResultsText: 'Nenhuma opção encontrada',
            noChoicesText: 'Todas as opções selecionadas',
            itemSelectText: 'Selecionar',
            addItemText: (value) => {
                return `Aperte Enter para adicionar <b>"${value}"</b>`;
            },
            maxItemText: (maxItemCount) => {
                return `Apenas ${maxItemCount} opções podem ser selecionadas`;
            },
            valueComparer: (value1, value2) => {
                return value1 === value2;
            },
            classNames: {
                containerInner: 'rounded-md border border-gray-700 w-full inline-block',
                input: 'choices-inner-input',
            },
            fuseOptions: {
                threshold: 0.3
            }
        })
        choicesSelect.setValue(items)
    })

    // TEXT EDITOR
    tinyMCE.init({
        selector: '.tinymce',
        language: 'pt_BR',
        language_url: `${window.location.origin}/public/js/pt_BR.js`,
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        toolbar: "undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl",
        menubar: 'file edit view insert format tools table help',
        automatic_uploads: true,
        relative_urls: false,
        setup: function (editor) {
            editor.on('blur', evt => {
                document.getElementById(editor.id).value = tinyMCE.activeEditor.getContent()
            })
        },
        init_instance_callback: function (editor) {
            const deleteImg = async function (editor, image, removedImgs) {
                let formData = new FormData()
                formData.append('image', image.src.replace(`${window.location.origin}/`, ''))

                await axios.post(`${window.location.origin}/image/delete`, formData)
                    .then(response => {
                        document.querySelector(`input[name="img[]"][value="${response.data.id}"]`)?.remove()
                        removedImgs.push(image.src)
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }

            const MutationObserver = window.MutationObserver || window.WebKitMutationObserver
            const obresver = new MutationObserver(async (mutations, instance) => {
                const removedImgs = new Array()
                for (let mutation of mutations) {
                    for (let element of mutation.removedNodes) {
                        if (element.nodeName === "IMG" && removedImgs.indexOf(element.src) < 0) {
                            await deleteImg(editor, element, removedImgs)
                            continue
                        }

                        element.childNodes.forEach(img => {
                            if (img.nodeName === "IMG" && removedImgs.indexOf(img.src) < 0) {
                                deleteImg(editor, img, removedImgs)
                            }
                        })
                    }
                }
            })

            obresver.observe(editor.getBody(), {childList : true, subtree: true})
        },
        images_upload_handler: function (blobInfo, success, failure, progress) {
            const editor = tinyMCE.activeEditor.getElement()
            const compressor = new Compressor(blobInfo.blob(), {
                quality: .8,
                maxWidth: 800,
                success(file) {
                    const formData = new FormData()
                    formData.append('image', file, file.name)

                    axios.post(`${window.location.origin}/image/store`, formData, {
                        onUploadProgress: function(progressEvent) {
                            let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                            progress(percentCompleted)
                        }
                    }).then(response => {
                        success(`${window.location.origin}/${response.data.location}`)
                        const form = editor.closest('form')
                        const imgInput = document.createElement('input')
                        imgInput.name = 'img[]'
                        imgInput.type = 'hidden'
                        imgInput.value = response.data.id
                        form.append(imgInput)
                    }).catch(response => {
                        failure(response)
                    })
                }
            })
        },
        file_picker_callback: function (callback, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    callback(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        }
    })

    const inputs = document.querySelectorAll( 'input[type="file"]' );
    Array.prototype.forEach.call( inputs, function( input )
    {
        let label	 = input.previousElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            let fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });
    });
})();