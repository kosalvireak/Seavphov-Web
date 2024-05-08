<template>
  <div class="Signup row">
    <div class="d-flex-center logo col-md-6 col-sm-12">
      <img src="/img/book.png" alt="booklogo" class="logoimg img-fluid" />
    </div>
    <div class="container col-md-6 col-sm-12">
      <h1>Sign Up</h1>
      <form v-on:submit.prevent="Signup()">
        <div class="form-floating mb-3">
          <MDBInput
            type="text"
            label="Name"
            id="name"
            v-model="name"
            wrapperClass="bg-white p-2"
            required
          />
        </div>
        <div class="form-floating mb-3">
          <MDBInput
            type="email"
            label="Email address"
            id="email"
            v-model="email"
            wrapperClass="bg-white p-2"
            required
          />
        </div>
        <div class="form-floating password mb-3">
          <MDBInput
            type="password"
            label="Password"
            id="password"
            v-model="password"
            wrapperClass="bg-white p-2"
            required
          />
        </div>
        <div class="form-floating mb-3">
          <MDBInput
            type="password"
            label="Confirm Password"
            id="password_confirmation"
            v-model="password_confirmation"
            wrapperClass="bg-white p-2"
            required
          />
        </div>
        <div class="d-flex align-items-start justify-content-between my-3">
          <div class="d-flex justify-content-center align-items-start">
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
        </div>
        <p v-if="Error" class="text-danger">{{ errorMessage }}</p>
        <button
          type="submit"
          class="btn btn-primary mt-2 d-flex-center btn_submit"
        >
          <span v-if="!isLoading">Signup</span>
          <Loader v-else :size="20" :Color="'#FFFFFF'" />
        </button>
      </form>

      <div class="text-center mt-3">
        Already have an account?
        <a
          @click="
            () => {
              this.$router.push('/login');
            }
          "
          class="text-seavphov"
          >Login.</a
        >
      </div>
    </div>
  </div>
</template>
  
<script>
import Loader from "../components/Loader.vue";
import { MDBInput } from "mdb-vue-ui-kit";
export default {
  name: "Signup",
  components: { Loader, MDBInput },
  data() {
    return {
      email: "virakvary@gmail.com",
      name: "virak",
      password: "12345678",
      password_confirmation: "12345678",
      Error: false,
      errorMessage: "",
      isShowPassword: false,
      isLoading: false,
    };
  },
  methods: {
    async Signup() {
      if (this.password.length >= 8) {
        if (this.password == this.password_confirmation) {
          const signupData = {
            email: this.email,
            name: this.name,
            password: this.password,
            password_confirmation: this.password_confirmation,
          };
          this.isLoading = true;
          await this.$store.dispatch("registerUser", signupData);
          this.isLoading = false;
        } else {
          this.Error = true;
          this.errorMessage = "Password & confirm password does not match!";
        }
      } else {
        this.Error = true;
        this.errorMessage = "Password must be 8 characters or more";
      }
    },

    showPassword() {
      if (this.isShowPassword) {
        password.type = "password";
        password_confirmation.type = "password";
      } else {
        password.type = "text";
        password_confirmation.type = "text";
      }
    },
    forgotPassword() {
      this.$router.push("/forgot-password");
    },
  },
};
</script>
  
<style scoped>
.Signup {
  margin-bottom: 100px !important ;
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
button {
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
}

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
.btn_submit {
  width: 200px;
  height: 51px;
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
}
</style>