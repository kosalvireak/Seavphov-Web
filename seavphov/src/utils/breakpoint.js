import { reactive } from "vue";

export const resizeState = reactive({
    isMobile: window.innerWidth < 768,
});

function updateIsMobile() {
    resizeState.isMobile = window.innerWidth < 768;
}

export function setupResizeListener() {
    window.addEventListener("resize", updateIsMobile);
    updateIsMobile(); // set initial value
}