<template>
  <div class="Login row p-3 m-0 shadow-5">
    <a href="/home" class="text-gray">
      <i class="fa fa-arrow-circle-left pe-2" aria-hidden="true"></i>Home
    </a>
    <div
      class="d-flex align-items-center justify-content-center logo col-md-6 col-sm-12"
    >
      <img src="/img/book.png" alt="booklogo" class="logoimg img-fluid" />
    </div>
    <div class="container col-md-6 col-sm-12">
      <h1>Log In</h1>
      <form v-on:submit.prevent="Login()">
        <div class="form-floating mb-3">
          <MDBInput
            type="email"
            label="Email address"
            id="email"
            v-model="email"
            wrapperClass="bg-white h-3rem"
            required
          />
        </div>
        <div class="form-floating">
          <MDBInput
            type="password"
            label="Password"
            id="password"
            v-model="password"
            wrapperClass="bg-white h-3rem"
            required
          />
        </div>

        <div class="d-flex align-items-start justify-content-between my-3">
          <div class="d-flex justify-content-center">
            <div
              class="form-check h-100 d-flex align-items-start justify-content-center"
            >
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                id="form1Example3"
                checked
                v-model="isShowPassword"
                @click="showPassword"
              />
              <label class="form-check-label" for="form1Example3">
                Show password
              </label>
            </div>
          </div>

          <div class="text-seavphov">
            <label @click="forgotPassword()" class="cursor-pointer"
              >Forgot password?</label
            >
          </div>
        </div>
        <p v-if="Error" class="text-danger">{{ errorMessage }}</p>
        <!-- <button
          type="submit"
          class="btn btn-primary mt-2 d-flex-center btn_submit"
        >
          <span v-if="!isLoading">Login</span>
          <Loader v-else :size="20" :Color="'#FFFFFF'" />
        </button> -->
        <div class="form-floating d-flex-center">
          <button
            type="submit"
            class="btn btn-primary mt-2 d-flex-center btn_submit"
          >
            <span v-if="!isLoading">Login</span>
            <Loader v-else :size="15" :Color="'#FFFFFF'" />
          </button>
        </div>
      </form>

      <div class="text-center mt-3">
        Doesn't have an account?
        <a
          @click="
            () => {
              this.$router.push('/signup');
            }
          "
          class="text-seavphov"
          >Register!</a
        >
      </div>
    </div>
  </div>
</template>
  
  <script>
import Loader from "../components/Loader.vue";
import { MDBInput } from "mdb-vue-ui-kit";
export default {
  name: "Login",
  components: { Loader, MDBInput },
  data() {
    return {
      email: "",
      password: "",
      Error: false,
      errorMessage: "",
      isLoading: false,
      isShowPassword: false,
    };
  },
  methods: {
    async Login() {
      if (this.email.length == 0 || this.password.length == 0) {
        this.Error = true;
        this.errorMessage = "Email or password cannot be empty!";
      } else if (this.email.length > 0 || this.password.length > 6) {
        const loginData = {
          email: this.email,
          password: this.password,
        };
        this.isLoading = true;
        await this.$store.dispatch("loginUser", loginData);
        this.isLoading = false;
      } else {
        this.Error = true;
        this.errorMessage = "Incorrect email or password!";
      }
    },
    showPassword() {
      if (this.isShowPassword) {
        password.type = "password";
      } else {
        password.type = "text";
      }
    },
    forgotPassword() {
      this.$router.push("/forgot-password");
    },
    redirectHome() {
      this.$router.push("/home");
    },
  },
};
</script>
  
<style scoped>
.Login {
  margin-top: 100px !important ;
}
.row {
  background-color: #fff;
  border-radius: 30px;
  width: 900px;
  padding: 20px;
}

.logo {
  text-align: center;
}

.logoimg {
  max-width: 300px;
}
h1 {
  font-size: 50px;
  font-weight: bold;
  margin-bottom: 25px;
  color: #5c836e;
  text-align: center;
}

form {
  width: 100%;
  text-align: center;
}

label {
  margin-bottom: 5px;
  text-align: center;
  display: block;
  margin: 0 auto;
}
label::after {
  background-color: #d9d9d9 !important;
  width: 100% !important;
}

.special-style {
  width: 430px !important;
}
/*button {
  text-align: center;
  background-color: #5c836e;
  color: #fff;
  padding: 7px 70px;
  max-width: 300px;
  margin: auto;
  border-radius: 15px;
  font-weight: bold;
  font-size: 25px;
  cursor: pointer;
} */

button:hover {
  background-color: #444;
}

.btn {
  text-transform: unset !important;
}

.no-account {
  margin-top: 15px;
  font-size: 12px;
  color: #666;
  text-align: center;
}

a {
  color: #a3b18a;
  text-decoration: none;
}

/* .btn_submit {
  width: 200px;
  height: 51px;
} */
.btn_submit {
  width: 80px;
  height: 40px;
  background-color: #5c836e;
  color: #ffffff;
}
@media (max-width: 768px) {
  .logoimg {
    max-width: 150px;
  }
  .button {
    width: 200px;
  }
  .row {
    width: 100%;
  }
  .special-style {
    width: 370px !important;
  }
  .Login {
    margin-top: 0px !important ;
  }
}
</style>