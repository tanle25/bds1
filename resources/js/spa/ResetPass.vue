<template>
    <!-- Provides the application the proper gutter -->
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
                    Cập nhật mật khẩu
                </h1>
                <v-form ref="form" v-model="valid" class="login-wraper">
                    <v-alert
                        v-if="resetPassError"
                        :color="alertColor"
                        transition="scale-transition"
                        text
                        :type="resetStatus"
                    >
                        {{ resetPassError }}
                    </v-alert>

                    <v-text-field
                        v-model="email"
                        :counter="max"
                        :rules="[rules.required, rules.emailMatch]"
                        label="Email"
                        outlined
                        class="mb-4 mt-4"
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
                        class="mb-2"
                        outlined
                        @click:append="show1 = !show1"
                    ></v-text-field>

                    <v-text-field
                        v-model="passwordConfirm"
                        :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[
                            rules.required,
                            rules.min,
                            rules.confirmPassword
                        ]"
                        :type="show2 ? 'text' : 'password-confirm'"
                        name="input-10-1"
                        label="Xác nhận mật khẩu"
                        hint="Tối thiểu 6 ký tự"
                        counter
                        prepend-inner-icon="mdi-key-variant"
                        class="mb-2"
                        outlined
                        @click:append="show2 = !show2"
                    ></v-text-field>

                    <div class="d-flex forgot-password justify-space-between">
                        <router-link
                            to="/v2/login"
                            class="primary--text darken-4 font-weight-medium text-decoration-none"
                            >Đăng nhập</router-link
                        >

                        <router-link
                            to="/v2/register"
                            class="primary--text font-weight-medium text-decoration-none"
                            >Tạo tài khoản mới?</router-link
                        >
                    </div>
                    <div @click="submit" class="mt-5">
                        <v-btn
                            depressed
                            :loading="loading"
                            block
                            x-large
                            color="primary"
                            >Cập nhật mật khẩu mới</v-btn
                        >
                    </div>
                </v-form>
            </v-card>
        </div>
    </v-container>
</template>

<script>
export default {
    data: function() {
        return {
            loading: false,
            valid: false,
            alertColor: "",
            resetPassError: "",
            passwordConfirm: "",
            password: "",
            email: "",
            resetStatus: "",
            show1: false,
            show2: false,
            max: 100,
            rules: {
                required: value => !!value || "Không được để trống trường này.",
                emailMatch: v =>
                    /.+@.+\..+/.test(v) || "Email không đúng định dạng",
                min: v => v.length >= 6 || "Mật khẩu phải tối thiểu 6 ký tự",
                confirmPassword: v =>
                    v === this.password ||
                    "Mật khẩu xác nhận phải trùng với mật khẩu mới!"
            }
        };
    },
    computed: {
        token: function() {
            return this.$route.query.token;
        }
    },
    methods: {
        validate() {
            this.$refs.form.validate();
        },
        getPass() {
            this.resetPassError = "";
            this.loading = true;
            this.axios({
                method: "post",
                url: "/reset-password/update",
                data: {
                    reset_email: this.email,
                    reset_password: this.password,
                    reset_password_confirmation: this.passwordConfirm,
                    token: this.token
                },
                headers: {
                    "Content-Type": "application/json"
                }
            })
                .then(res => {
                    this.loading = false;
                    if (res.data) {
                        this.resetStatus = "success";
                        this.resetPassError = res.data.reset_status;
                        this.alertColor = "success";
                    }
                })
                .catch(err => {
                    if (err.response) {
                        if (err.response.status == 422) {
                            this.resetStatus = "error";
                            this.resetPassError =
                                err.response.data.password_reset;
                            this.alertColor = "error";
                        }
                    }
                    this.loading = false;
                });
        },
        submit() {
            console.log(this.token);
            this.validate();
            if (this.valid) {
                this.getPass();
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
