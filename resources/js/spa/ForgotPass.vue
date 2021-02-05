<template>
    <!-- Provides the application the proper gutter -->
    <div class="web-contain">
        <v-container>
            <div class="form-wraper d-flex flex-column align-center">
                <div>
                    <v-img
                        :lazy-src="this.$store.state.logo"
                        width="300px"
                        class="mb-5"
                        :src="this.$store.state.logo"
                    ></v-img>
                </div>
                <v-card class="mx-auto pa-10" elevation="15">
                    <h1 class="text-center primary--text mb-3">
                        Quên mật khẩu
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
                            label="Email lấy lại mật khẩu"
                            outlined
                            class="mb-4 mt-4"
                            prepend-inner-icon="mdi-account"
                        ></v-text-field>

                        <div
                            class="d-flex forgot-password justify-space-between"
                        >
                            <router-link
                                to="/v2/login"
                                class="primary--text darken-4 font-weight-medium text-decoration-none"
                                >Đã có tài khoản</router-link
                            >

                            <router-link
                                to="/v2/login"
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
                                >Gửi link xác nhận mật khẩu</v-btn
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
            valid: false,
            alertColor: "",
            resetPassError: "",
            email: "",
            resetStatus: "",
            show1: false,
            max: 100,
            rules: {
                required: value => !!value || "Không được để trống trường này.",
                emailMatch: v =>
                    /.+@.+\..+/.test(v) || "Email không đúng định dạng"
            }
        };
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
                url: "/forgot-password",
                data: {
                    email_reset: this.email
                },
                headers: {
                    "Content-Type": "application/json"
                }
            })
                .then(res => {
                    this.loading = false;
                    if (res.data) {
                        this.resetStatus = "success";
                        this.resetPassError = res.data.status;
                        this.alertColor = "success";
                    }
                })
                .catch(err => {
                    if (err.response) {
                        if (err.response.status == 403) {
                            this.resetStatus = "error";
                            this.resetPassError = err.response.data.email_reset;
                            this.alertColor = "error";
                        }
                    }
                    this.loading = false;
                });
        },
        submit() {
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
