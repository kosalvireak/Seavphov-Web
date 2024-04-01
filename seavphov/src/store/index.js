import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import { useToast } from "vue-toastification"
import axios from "axios"

const backend_url = import.meta.env.VITE_BACKEND_URL;
const toast = useToast();
const CONDITION = {
    AS_NEW: 'As-new',
    GOOD: 'Good',
    WELL_WORN: 'Well-worn',
};

const AVAILABILITY = {
    TRUE: true,
    FALSE: false
}

const SAVEDBOOK = {
    TRUE: true,
    FALSE: false
}

const CATEGORIES = {
    FICTION: 'Fiction',
    NOVEL: 'Novel',
    TEXT_BOOK: 'Text-Book',
    HISTORY: 'History',
    SCIENCE: 'Science',
    FANTASY: 'Fantasy',
}

const store = createStore({
    plugins: [createPersistedState({
        storage: window.sessionStorage,
    })],
    state: {
        users: [
            {
                email: "virakvary@gmail.com",
                password: "12345678",
                profile: "https://scontent.fpnh2-1.fna.fbcdn.net/v/t39.30808-6/408715420_329255713210706_8267503967006690585_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=efb6e6&_nc_eui2=AeFEiBQr97qZht7vYvxKQgJ5vYtgfsSr4UC9i2B-xKvhQG-T0GyfyLk8Ez5Top7Sm4zIjLpe65dVIusot0S_KnUM&_nc_ohc=5roejroO1mwAX-3Nvrm&_nc_zt=23&_nc_ht=scontent.fpnh2-1.fna&oh=00_AfCjmktnTe5-9-Fnk1J5_hyrFA2Wcrx74qFQzpP3I4A-0w&oe=659A57F6",
            },
            {
                email: "david@gmail.com",
                password: "12345678",
                profile: "https://scontent.fpnh2-2.fna.fbcdn.net/v/t39.30808-6/410228260_6840343219419819_3455081290048657551_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=efb6e6&_nc_eui2=AeEGRKGj-zkAV-k5mnhnPXeVT_JOaHvos3FP8k5oe-izcSxCN-aKiddZmrcgQL6k_jDd2z6XK7XMey8WEYEM_rnd&_nc_ohc=qGgiPL09EVAAX-jj6ds&_nc_zt=23&_nc_ht=scontent.fpnh2-2.fna&oh=00_AfCZx3q1lR_2Go_7jrQP3ru9aD6aouoDBciE-6RL87mnHA&oe=659B64A9",

            },
            {
                email: "nyvath@gmail.com",
                password: "12345678",
                profile: "https://scontent.fpnh2-3.fna.fbcdn.net/v/t39.30808-6/410385958_2028434880840692_1714898826776506602_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=9c7eae&_nc_eui2=AeEoKJD2QOuDz4yBi5tsQ4bOGwSrX1QdoWEbBKtfVB2hYWrQj2l5z31rXqPdweJmMHrcaLguAHs437e3EaUsjszY&_nc_ohc=u5Dq5YRx4eYAX8VgX-I&_nc_zt=23&_nc_ht=scontent.fpnh2-3.fna&oh=00_AfCnMBcp97DfhWrhbChfVzgNWwQJZgMZpujt4MMVvLXn_w&oe=659A3160",

            },
            {
                email: "theary@gmail.com",
                password: "12345678",
                profile: "https://scontent.fpnh2-3.fna.fbcdn.net/v/t39.30808-6/405185145_1730173207470631_4416260050122501943_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=efb6e6&_nc_eui2=AeF7dgqYUqx7XL_JGXd9q7cEJRwdZbzRetUlHB1lvNF61dc9jS_z30dhDXFlwQsxp8f8486cqF_7O7wKPGiaWylI&_nc_ohc=tvudgrHNxg8AX9aQaoF&_nc_zt=23&_nc_ht=scontent.fpnh2-3.fna&oh=00_AfAQ65ctTAlez4PJR6XA6vpd2QYg0yuLIAKMTcGOayug6A&oe=659AB98B",
            }
        ],
        loggedInUser: {
            username: "Anonymous",
            profile: "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png",
        },
        books: [
            {
                id: 1,
                title: "Angkor and the Khmer Civilization",
                author: "Michael D. Coe",
                images: ["/img/Angkor and the Khmer Civilization.jpg"],
                descriptions: "A great deal is now known about the brilliant Khmer civilization that flourished among the monsoon forests and rice paddies of mainland Southeast Asia, thanks to the pioneering work of French scholars and the application of modern archaeological techniques such as remote sensing from the space shuttle. A great deal is now known about the brilliant Khmer civilization that flourished among the monsoon forests and rice paddies of mainland Southeast Asia, thanks to the pioneering work of French scholars and the application of modern archaeological techniques such as remote sensing from the space shuttle. A great deal is now known about the brilliant Khmer civilization that flourished among the monsoon forests and rice paddies of mainland Southeast Asia, thanks to the pioneering work of French scholars and the application of modern archaeological techniques such as remote sensing from the space shuttle.",
                condition: CONDITION.AS_NEW,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.HISTORY,
                username: "Todd",
            },
            {
                id: 2,
                title: "The Enchanted Forest Chronicles",
                author: "Patricia C. Wrede",
                images: ["/img/The Enchanted Forest Chronicles.webp"],
                descriptions: "Join Princess Cimorene in a delightful fantasy world filled with dragons, wizards, and magical adventures.",
                condition: CONDITION.AS_NEW,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.NOVEL,
                username: "Todd"
            },
            {
                id: 3,
                title: "Quantum Paradox",
                author: "Ryan A. Greene",
                images: ["/img/Quantum Paradox.jpg"],
                descriptions: "Dive into the mind-bending world of quantum physics and explore the paradoxes that challenge our understanding of reality.",
                condition: CONDITION.GOOD,
                issaved: SAVEDBOOK.TRUE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.TEXT_BOOK,
                username: "Todd"
            },
            {
                id: 4,
                title: "Exploring the Cosmos",
                author: "Dr. Neil Armstrong",
                images: ["/img/Exploring the Cosmos.webp"],
                descriptions: "Embark on a cosmic journey with Dr. Neil Armstrong as he explores the wonders of the universe.",
                condition: CONDITION.AS_NEW,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.SCIENCE,
                username: "Todd",
            },
            {
                id: 5,
                title: "Mysteries of the Ancient World",
                author: "Elena P. Miller",
                images: ["/img/Mysteries of the Ancient World.webp"],
                descriptions: "Unravel the secrets of ancient civilizations and the mysteries that still captivate historians today.",
                condition: CONDITION.GOOD,
                issaved: SAVEDBOOK.TRUE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.HISTORY,
                username: "Todd",
            },
            {
                id: 6,
                title: "Shadow of the Eclipse",
                author: "Jonathan K. Black",
                images: ["/img/Shadow of the Eclipse.jpg"],
                descriptions: "A thrilling tale of magic, prophecies, and a world on the brink of darkness during a rare celestial event.",
                condition: CONDITION.AS_NEW,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.FICTION,
                username: "Todd",
            },
            {
                id: 7,
                title: "The Alchemist's Legacy",
                author: "Sophie R. Gardner",
                images: ["/img/The Alchemist's Legacy.jpg"],
                descriptions: "Follow the journey of an aspiring alchemist as they seek the legendary philosopher's stone and unlock the secrets of transmutation.",
                condition: CONDITION.WELL_WORN,
                issaved: SAVEDBOOK.TRUE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.FICTION,
                username: "Todd",
            },
            {
                id: 8,
                title: "The Future Of Coding",
                author: "Alex Q. Developer",
                images: ["/img/The Future Of Coding.jpg"],
                descriptions: "Explore the fascinating world of programming and its impact on shaping the future of technology.",
                condition: CONDITION.GOOD,
                issaved: SAVEDBOOK.TRUE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.TEXT_BOOK,
                username: "Todd",
            },
            {
                id: 9,
                title: "The Celestial Symphony",
                author: "Aria S. Harmon",
                images: ["/img/The Celestial Symphony.jpg"],
                descriptions: "Journey through the cosmos as celestial beings orchestrate the fate of the universe in a symphony of cosmic proportions.",
                condition: CONDITION.WELL_WORN,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.FALSE,
                categories: CATEGORIES.FICTION,
                username: "Todd",
            },
            {
                id: 10,
                title: "Riddles of the Sphinx",
                author: "Samuel R. Enigma",
                images: ["/img/Riddles of the Sphinx.jpg"],
                descriptions: "Solve the ancient riddles guarded by the Sphinx and unveil the hidden truths that lie beneath the sands of time.",
                condition: CONDITION.AS_NEW,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.MYSTERY,
                username: "Todd",
            },
            {
                id: 11,
                title: "Chronicles of the Shadow",
                author: "Astrid Nova",
                images: ["/img/Chronicles of the Shadow.jpg"],
                descriptions: "Embark on an epic space odyssey with Captain Nova as she navigates the uncharted territories of the cosmos.",
                condition: CONDITION.GOOD,
                issaved: SAVEDBOOK.TRUE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.SCIENCE_FICTION,
                username: "Todd",
            },
            {
                id: 12,
                title: "The Legend of Zelda: Tears of the Kingdom",
                author: "Elysia E. Evergreen",
                images: ["/img/Tears of the Kingdom.jpg"],
                descriptions: "Immerse yourself in the enchanting world of Elaria, where magical crystals hold the key to the kingdom's destiny.",
                condition: CONDITION.WELL_WORN,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.FALSE,
                categories: CATEGORIES.FANTASY,
                username: "Todd",
            }, {
                id: 13,
                title: "Angkor and the Khmer Civilization part 2",
                autor: "Michael D. Coe",
                images: ["/img/Angkor and the Khmer Civilization.jpg"],
                descriptions: "A great deal is now known about the brilliant Khmer civilization that flourished among the monsoon forests and rice paddies of mainland Southeast Asia, thanks to the pioneering work of French scholars and the application of modern archaeological techniques such as remote sensing from the space shuttle.",
                condition: CONDITION.AS_NEW,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.HISTORY,
                username: "Todd",
                comment: 'lol that is so funny'
            },
            {
                id: 14,
                title: "The Enchanted Forest Chronicles part 2",
                author: "Patricia C. Wrede",
                images: ["/img/The Enchanted Forest Chronicles.webp"],
                descriptions: "Join Princess Cimorene in a delightful fantasy world filled with dragons, wizards, and magical adventures.",
                condition: CONDITION.AS_NEW,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.NOVEL,
                username: "Todd"
            },
            {
                id: 15,
                title: "Quantum Paradox part 2",
                author: "Ryan A. Greene",
                images: ["/img/Quantum Paradox.jpg"],
                descriptions: "Dive into the mind-bending world of quantum physics and explore the paradoxes that challenge our understanding of reality.",
                condition: CONDITION.GOOD,
                issaved: SAVEDBOOK.TRUE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.TEXT_BOOK,
                username: "Todd"
            },
            {
                id: 16,
                title: "Exploring the Cosmos part 2",
                author: "Dr. Neil Armstrong",
                images: ["/img/Exploring the Cosmos.webp"],
                descriptions: "Embark on a cosmic journey with Dr. Neil Armstrong as he explores the wonders of the universe.",
                condition: CONDITION.AS_NEW,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.SCIENCE,
                username: "Todd",
            },
            {
                id: 17,
                title: "Mysteries of the Ancient World part 2",
                author: "Elena P. Miller",
                images: ["/img/Mysteries of the Ancient World.webp"],
                descriptions: "Unravel the secrets of ancient civilizations and the mysteries that still captivate historians today.",
                condition: CONDITION.GOOD,
                issaved: SAVEDBOOK.TRUE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.HISTORY,
                username: "Todd",
            },
            {
                id: 18,
                title: "Shadow of the Eclipse part 2",
                author: "Jonathan K. Black",
                images: ["/img/Shadow of the Eclipse.jpg"],
                descriptions: "A thrilling tale of magic, prophecies, and a world on the brink of darkness during a rare celestial event.",
                condition: CONDITION.AS_NEW,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.FICTION,
                username: "Todd",
            },
            {
                id: 19,
                title: "The Alchemist's Legacy part 2",
                author: "Sophie R. Gardner",
                images: ["/img/The Alchemist's Legacy.jpg"],
                descriptions: "Follow the journey of an aspiring alchemist as they seek the legendary philosopher's stone and unlock the secrets of transmutation.",
                condition: CONDITION.WELL_WORN,
                issaved: SAVEDBOOK.TRUE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.FICTION,
                username: "Todd",
            },
            {
                id: 20,
                title: "The Future Of Coding part 2",
                author: "Alex Q. Developer",
                images: ["/img/The Future Of Coding.jpg"],
                descriptions: "Explore the fascinating world of programming and its impact on shaping the future of technology.",
                condition: CONDITION.GOOD,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.TEXT_BOOK,
                username: "Todd",
            },
            {
                id: 21,
                title: "The Celestial Symphony part 2",
                author: "Aria S. Harmon",
                images: ["/img/The Celestial Symphony.jpg"],
                descriptions: "Journey through the cosmos as celestial beings orchestrate the fate of the universe in a symphony of cosmic proportions.",
                condition: CONDITION.WELL_WORN,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.FALSE,
                categories: CATEGORIES.FICTION,
                username: "Todd",
            },
            {
                id: 22,
                title: "Riddles of the Sphinx part 2",
                author: "Samuel R. Enigma",
                images: ["/img/Riddles of the Sphinx.jpg"],
                descriptions: "Solve the ancient riddles guarded by the Sphinx and unveil the hidden truths that lie beneath the sands of time.",
                condition: CONDITION.AS_NEW,
                issaved: SAVEDBOOK.TRUE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.MYSTERY,
                username: "Todd",
            },
            {
                id: 23,
                title: "Chronicles of the Shadow part 2",
                author: "Astrid Nova",
                images: ["/img/Chronicles of the Shadow.jpg"],
                descriptions: "Embark on an epic space odyssey with Captain Nova as she navigates the uncharted territories of the cosmos.",
                condition: CONDITION.GOOD,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.SCIENCE_FICTION,
                username: "Todd",
            },
            {
                id: 24,
                title: "The Legend of Zelda: Tears of the Kingdom part 2",
                author: "Elysia E. Evergreen",
                images: ["/img/Tears of the Kingdom.jpg"],
                descriptions: "Immerse yourself in the enchanting world of Elaria, where magical crystals hold the key to the kingdom's destiny.",
                condition: CONDITION.WELL_WORN,
                issaved: SAVEDBOOK.FALSE,
                availability: AVAILABILITY.TRUE,
                categories: CATEGORIES.FANTASY,
                username: "Todd",
            }
        ],
        booksCopy: [],
        savedbooks: [3, 5, 7, 8, 11, 17, 22],
        mybooks: [2, 4, 9, 12],
        searchWord: "",
        isLoggedIn: false,

        // start backend
        filteredFetchBook: [],
        book: {},
        // end backend
    },

    getters: {
        allUsers(state) {
            return state.users;
        },
        loggedInUser(state) {
            return state.loggedInUser;
        },
        allBooks(state) {
            return state.books;
        },
        book: (state) => (id) => {
            return state.books.filter(book => book.id == id);
        },
        savedBooks(state) {
            // take all the books and filter out only book that has id match what inside array savedbooks
            return state.books.filter(book => state.savedbooks.includes(book.id));
        },
        myBooks(state) {
            // take all the books and filter out only book that has id match what inside array mybooks
            return state.books.filter(book => state.mybooks.includes(book.id));
        },
        searchWord(state) {
            return state.searchWord;
        },
        loggedInState(state) {
            return state.isLoggedIn;
        },

        // start backend
        booksByCategory: (state) => (category) => {
            return state.fetchBooks.filter(book => book.categories == category);
        },
        // end backend
    },
    mutations: {
        addLoggedInUser(state, payload) {
            state.loggedInUser.username = payload.username;
            state.loggedInUser.profile = payload.profile;
        },
        changeIsSavedToTrue(state, id) {
            state.books[id - 1].issaved = SAVEDBOOK.TRUE;
        },
        changeIsSavedToFalse(state, id) {
            state.books[id - 1].issaved = SAVEDBOOK.FALSE;
        },
        addTosavedbooks(state, id) {
            state.savedbooks.push(id);
        },
        removeFromsavedbooks(state, id) {
            state.savedbooks = state.savedbooks.filter(element => element !== id);
        },
        addSearchWord(state, word) {
            state.searchWord = word;
        },
        addNewBookTobooks(state, book) {
            state.books.push(book);
        },
        loggin(state) {
            state.isLoggedIn = true;
        },
        loggout(state) {
            state.isLoggedIn = false;
        }

    },
    actions: {
        // start backend
        async fetchBooksWithFilter({ commit }, filters) {
            const params = new URLSearchParams();
            if (filters.title) {
                params.append('title', filters.title);
            }
            if (filters.author) {
                params.append('author', filters.author);
            }
            if (filters.categories) {
                params.append('categories', filters.categories);
            }
            try {
                const response = await axios.get(backend_url + `/api/books?${params.toString()}`); // Add params to URL
                if (response.data.success) {
                    this.state.filteredFetchBook = response.data.message.data;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async fetchBookById({ commit }, id) {
            try {
                const response = await axios.get(backend_url + "/api/books/" + id)
                if (response.data.success) {
                    this.state.book = response.data.message;
                }
            } catch (error) {
                toast.error(error.response.data.message);
            }
        },
        async createBook({ commit }, formData) {
            // for (var key of this.formData.entries()) {
            //   console.log(key[0] + ", " + key[1]);
            // }

            try {
                const response = await axios.post(backend_url + "/api/books/", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                console.log("response", response);

            } catch (error) {
                console.error("Error adding book:", error);
                toast.error(error.response.data.message);
            }
        },


        // end backend
        changeIsSaved({ commit }, id) {
            id = parseInt(id);
            // if book is already saved. Change issaved to False and remove from array 
            if (this.state.books[id - 1].issaved) {
                commit('changeIsSavedToFalse', id);
                commit('removeFromsavedbooks', id);
            } else {
                // else book is already saved. Change issaved to True and push from array 
                commit('changeIsSavedToTrue', id);
                commit('addTosavedbooks', id);
            }
        },
        addLoggedInUser({ commit }, { email, profile }) {
            let username0 = email.split('@');
            const username = username0[0];
            commit('addLoggedInUser', { username, profile });
        },
        addSearchWord({ commit }, word) {
            commit('addSearchWord', word);
        },
        logUserIn({ commit }) {
            commit('loggin');
        },
        logUserOut({ commit }) {
            commit('loggout');
        },
    },


})

export default store