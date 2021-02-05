<template>
    <!-- Provides the application the proper gutter -->
    <div class="web-contain">
        <v-container>
            <div class="form-wraper d-flex flex-column align-center">
                <div>
                    <v-img
                        :lazy-src="this.$store.state.logo"
                        max-height="100"
                        class="mb-3"
                        :src="this.$store.state.logo"
                    ></v-img>
                </div>
                <v-card class="mx-auto pa-10" elevation="15">
                    <h1 class="text-center primary--text mb-3">Đăng ký</h1>

                    <v-form ref="form" v-model="valid" class="login-wraper">
                        <v-alert
                            color="red mb-3"
                            transition="scale-transition"
                            text
                            v-for="item in validateErrors"
                            :key="item"
                            type="error"
                        >
                            {{ item }}
                        </v-alert>

                        <v-text-field
                            v-model="email"
                            :counter="max"
                            :rules="[rules.required, rules.emailMatch]"
                            label="Email"
                            outlined
                            class="mb-2"
                            prepend-inner-icon="mdi-account"
                        ></v-text-field>

                        <v-text-field
                            v-model="fullname"
                            :counter="max"
                            :rules="[rules.required]"
                            label="Họ và tên"
                            outlined
                            class="mb-2"
                            prepend-inner-icon="mdi-account"
                        ></v-text-field>

                        <v-text-field
                            v-model="phone"
                            :counter="15"
                            :rules="[rules.required, rules.digits]"
                            label="Số điện thoại"
                            outlined
                            class="mb-2"
                            prepend-inner-icon="mdi-phone"
                        ></v-text-field>

                        <v-text-field
                            v-model="password"
                            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                            :rules="[rules.required, rules.min]"
                            :type="show1 ? 'text' : 'password'"
                            name="input-10-1"
                            label="Mật khẩu"
                            hint="Tối thiểu 6 ký tự"
                            counter
                            prepend-inner-icon="mdi-key-variant"
                            class="mb-2"
                            outlined
                            @click:append="show1 = !show1"
                        ></v-text-field>

                        <div
                            class="d-flex forgot-password justify-space-between"
                        >
                            <router-link
                                to="/v2/forgot-password"
                                class="black--text darken-4 font-weight-medium text-decoration-none"
                                >Quên mật khẩu</router-link
                            >

                            <router-link
                                to="/v2/login"
                                class="light-blue--text darken-4 font-weight-medium text-decoration-none"
                                >Đã có tài khoản?</router-link
                            >
                        </div>
                        <div class="mt-5">
                            <v-btn
                                @click="submit"
                                depressed
                                block
                                x-large
                                color="primary"
                                >Đăng ký</v-btn
                            >
                        </div>
                    </v-form>
                </v-card>
            </div>
        </v-container>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            validateErrors: {},
            valid: false,
            email: "",
            fullname: "",
            password: "",
            phone: "",
            show1: false,
            max: 30,
            rules: {
                required: value => !!value || "Không được để trống trường này.",
                min: v => v.length >= 6 || "Tối thiểu 6 ký tự",
                emailMatch: v =>
                    /.+@.+\..+/.test(v) || "Email không đúng định dạng",
                digits: v =>
                    /^[0-9]*$/.test(v) || "Số điện thoại phải là kiểu số"
            }
        };
    },

    methods: {
        validate() {
            this.$refs.form.validate();
        },
        register() {
            this.axios({
                method: "post",
                url: "/register",
                data: {
                    register_email: this.email,
                    register_fullname: this.fullname,
                    register_phone_number: this.phone,
                    register_password: this.password
                },
                headers: {
                    "Content-Type": "application/json"
                }
            })
                .then(res => {
                    console.log(res);
                    window.location = "/";
                })
                .catch(err => {
                    if (err.response) {
                        if (err.response.status == 422) {
                            this.validateErrors = Object.values(
                                err.response.data.errors
                            )[0];
                        }
                    }
                });
        },
        submit() {
            this.validate();
            if (this.valid) {
                this.register();
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.form-wraper {
    min-height: 100vh;
    padding: 100px 0;
    .login-wraper {
        width: 400px;
        max-width: 100%;
    }
    .forgot-password {
        font-size: 0.9rem;
    }
}
</style>
