<template>
    <!-- Provides the application the proper gutter -->
    <div class="web-contain">
        <v-container>
            <div class="form-wraper d-flex flex-column align-center">
                <div>
                    <v-img
                        :lazy-src="this.$store.state.logo"
                        width="300px"
                        class="mb-3"
                        :src="this.$store.state.logo"
                    ></v-img>
                </div>
                <v-card class="mx-auto pa-10" elevation="15">
                    <h1 class="text-center primary--text mb-3">
                        Đăng nhập
                    </h1>
                    <v-alert
                        v-if="loginError"
                        color="red mb-3"
                        transition="scale-transition"
                        text
                        type="error"
                    >
                        Không tìm thấy thông tin đăng nhập
                    </v-alert>
                    <v-form ref="form" v-model="valid" class="login-wraper">
                        <v-text-field
                            v-model="username"
                            :counter="max"
                            :rules="[rules.required]"
                            label="Email hoặc số điện thoại"
                            outlined
                            class="mb-4"
                            prepend-inner-icon="mdi-account"
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
                                to="/v2/register"
                                class="light-blue--text darken-4 font-weight-medium text-decoration-none"
                                >Đăng ký tài khoản mới</router-link
                            >
                        </div>
                        <div @click="submit" class="mt-5">
                            <v-btn
                                :loading="loading"
                                depressed
                                block
                                x-large
                                color="primary"
                                >Đăng nhập</v-btn
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
            loading: false,
            loginError: false,
            valid: false,
            username: "",
            password: "",
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
    created: function() {},
    methods: {
        validate() {
            this.$refs.form.validate();
        },
        login() {
            this.loginError = false;
            this.loading = true;
            this.axios({
                method: "post",
                url: "/login",
                data: {
                    username: this.username,
                    password: this.password
                },
                headers: {
                    "Content-Type": "application/json"
                }
            })
                .then(() => {
                    window.location = "/";
                })
                .catch(err => {
                    this.loginError = true;
                    this.loading = false;
                });
        },
        submit() {
            this.validate();
            if (this.valid) {
                this.login();
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
        width: 380px;
        max-width: 100%;
    }
    .forgot-password {
        font-size: 0.9rem;
    }
}
</style>
