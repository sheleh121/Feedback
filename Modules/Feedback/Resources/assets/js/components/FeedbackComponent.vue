<template>
    <div class="main-wrap">
        <div v-if="response_content !== null" class="alert alert-success alert-dismissible" role="alert">
            {{ response_content }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div v-if="response_error_content !== null" class="alert alert-danger alert-dismissible" role="alert">
            {{ response_error_content }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" @submit.prevent="send">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="user_name">Имя</label>
                        <input
                                v-model="form_data.user_name"
                                type="text"
                                :class="'form-control' + (form_error.user_name !== null ? ' is-invalid' : '')"
                                name="user_name"
                                id="user_name"
                                placeholder="Введите имя"
                        >
                        <span v-if="form_error.user_name !== null" class="invalid-feedback" role="alert">
                            <strong>{{ form_error.user_name }}</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input
                                v-model="form_data.email"
                                type="email"
                                :class="'form-control' + (form_error.email !== null ? ' is-invalid' : '')"
                                id="email"
                                name="email"
                                placeholder="Введите адрес электронной почты"
                        >
                        <span v-if="form_error.email !== null" class="invalid-feedback" role="alert">
                            <strong>{{ form_error.email }}</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="body">Вопрос</label>
                        <textarea
                                v-model="form_data.body"
                                :class="'form-control' + (form_error.email !== null ? ' is-invalid' : '')"
                                id="body"
                                name="body"
                                rows="10"
                        ></textarea>
                        <span v-if="form_error.body !== null" class="invalid-feedback" role="alert">
                            <strong>{{ form_error.body }}</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="attachments">Вложения</label>
                        <input
                                ref="file_input"
                                type="file" multiple
                                :class="'form-control-file' + (form_error.files !== null ? ' is-invalid' : '')"
                                name="attachments[]">
                        <span v-if="form_error.files !== null" class="invalid-feedback" role="alert">
                            <strong>{{ form_error.files }}</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <vue-recaptcha v-if="false" class="float-right"
                                   ref="recaptcha"
                                   :sitekey="sitekey"
                                   @verify="captchaVerify"
                                   @expired="onCaptchaExpired"
                    />
                    <button v-else type="submit" class="btn btn-success float-right">Отправить</button>
                </div>
            </div>
        </form>
    </div>

</template>

<script>
    import VueRecaptcha from 'vue-recaptcha'

    export default {
        name: 'FeedbackComponent',
        components: { VueRecaptcha },
        props: {
            sitekey: ''
        },
        data () {
            return {
                form_data: {
                    user_name: '',
                    email: '',
                    body: '',
                    files: [],
                    captcha_token: ''
                },
                form_error: {
                    user_name: null,
                    email: null,
                    body: null,
                    files: null
                },
                button_disabled: true,
                response_content: null,
                response_error_content: null
            }
        },

        methods: {
            send () {
                if (!this.validate()) return false;

                let files = this.$refs.file_input.files
                let form = new FormData();


                for (let i = 0; i < files.length; i++) {
                    form.append('attachments[]', files[i])
                }
                form.append('user_name', this.form_data.user_name);
                form.append('email', this.form_data.email);
                form.append('body', this.form_data.body);
                form.append('captcha_token', this.form_data.captcha_token );

                axios.post('/feedback', form)
                    .then((response) =>{
                        this.response_content = response.data;
                        this.form_data.user_name = this.form_data.email = this.form_data.body = '';
                        this.$refs.file_input.files = null;
                    })
                    .catch(error => {
                        this.response_error_content = error.response.data.error;
                        this.button_disabled = true;
                    });
            },

            validate () {
                this.form_error.user_name = this.form_error.email = this.form_error.body = this.form_error.files  = null;
                let files_size = 0;
                let errors = false;

                for( let file of this.$refs.file_input.files) {
                    files_size += file.size;
                }

                if (this.form_data.user_name.length < 2 || this.form_data.user_name.length > 25) {
                    this.form_error.user_name = 'Обязательно для заполнения. От 2 до 25 символов.';
                    errors = true;
                }
                if (this.form_data.body.length < 10 || this.form_data.body.length > 1000) {
                    this.form_error.body = 'Обязательно для заполнения. От 10 до 1000 символов.';
                    errors = true;
                }
                if (this.form_data.email.length < 5) {
                    this.form_error.email = 'Поле обязательно для заполнения.';
                }

                if (this.$refs.file_input.files.length > 5) {
                    this.form_error.files = 'Можно прикрепить не более пяти файлов.';
                }

                if (files_size > 1024 * 1024 * 40) {
                    if (this.form_error.files == null)
                        this.form_error.files = 'Общий размер файлов не должен превышать 40 мегабайт.';
                    else
                        this.form_error.files += ' Общий размер файлов не должен превышать 40 мегабайт.';
                }

                return !errors;
            },

            onCaptchaExpired () {
                this.$refs.recaptcha.reset()
            },

            captchaVerify (token) {
                this.button_disabled = false;
                this.form_data.captcha_token = token;
            }
        }
    }
</script>