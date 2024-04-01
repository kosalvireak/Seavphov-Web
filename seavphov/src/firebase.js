// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyB3_ocArYcH_xjghj_OXO13W_dPVu0jQ9M",
    authDomain: "seavphov-919d7.firebaseapp.com",
    projectId: "seavphov-919d7",
    storageBucket: "seavphov-919d7.appspot.com",
    messagingSenderId: "1096446548829",
    appId: "1:1096446548829:web:2edaa8323b6b9070b366b4"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
import { getStorage } from 'firebase/storage'
const storage = getStorage(app);

export { storage }