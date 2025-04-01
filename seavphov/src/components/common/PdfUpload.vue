<template>
  <div
      class="PdfUpload w-full relative clickable flex-center h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 p-1"
  >
    <input
        :id="`dropzone-file-${id}`"
        name="`dropzone-file-${id}`"
        type="file"
        class="clickable absolute top-0 left-0 right-0 bottom-0 w-full h-full block opacity-0"
        accept="application/pdf"
        @change="handlePdfChange"
    />
    <div
        v-if="!pdfUrl && !uploadingPdf"
        class="flex items-center justify-center"
        @dragover.prevent
        @drop.prevent="handleDrop"
    >
      <label
          :for="`dropzone-file-${id}`"
          class="flex flex-col items-center justify-center w-full"
      >
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
          <svg
              class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 20 16"
          >
            <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
            />
          </svg>
          <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
            <span class="font-semibold">Click to upload</span> or drag and drop
          </p>
          <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
            File Formats Accepted: <span class="font-semibold">PDF</span>
          </p>
        </div>
      </label>
    </div>
    <div v-else-if="uploadingPdf" class="flex-center">
      <div class="flex-center flex-col text-center">
        <svg
            class="animate-spin h-10 w-10 text-sp-secondary"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
        >
          <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
          ></circle>
          <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
          ></path>
        </svg>
        <p class="mt-2 text-gray-500">Uploading...</p>
      </div>
    </div>
    <div v-else class="relative w-full h-full max-h-64 relative">
      <img
          :src="pdfUrl"
          alt="Uploaded PDF"
          class="w-full h-full object-contain rounded-lg cursor-pointer"
          @click="triggerFileInput"
      />
      <input
          :id="`hidden-file-input-${id}`"
          :name="`hidden-file-input-${id}`"
          type="file"
          class="hidden"
          accept="application/pdf"
          @change="handlePdfChange"
      />
    </div>
  </div>
</template>

<script>
import { storage } from "../../firebase";
import { ref, uploadBytes, getDownloadURL } from "firebase/storage";

export default {
  name: "PdfUpload",
  props: {
    id: {
      type: String,
      default: "pdf",
    },
    initialPdf: String,
  },
  data() {
    return {
      uploadingPdf: false,
      pdfUrl: this.initialPdf,
      fileName: "",
    };
  },
  methods: {
    async handlePdfChange(event) {
      this.uploadingPdf = true;
      this.pdfUrl = "";
      try {
        const selectedFile = event.target.files[0];

        // Validate file type
        if (selectedFile.type !== "application/pdf") {
          throw new Error("Only PDF files are allowed.");
        }

        // Extract the file name
        this.fileName = selectedFile.name;

        // Validate file size (25MB limit)
        const maxSize = 25 * 1024 * 1024; // 25MB in bytes
        if (selectedFile.size > maxSize) {
          throw new Error("File size exceeds the 25MB limit.");
        }

        if (selectedFile) {
          const storageRef = ref(storage, `pdf/${selectedFile.name}`);
          const imageUpload = await uploadBytes(storageRef, selectedFile);
          const url = await getDownloadURL(
              ref(storage, imageUpload.metadata.fullPath)
          );
          this.pdfUrl = url;
          this.$emit("pdfUploaded", url);
        }
      } catch (error) {
        console.error("Error uploading pdf:", error);
        this.$toast.error(error.message);
      } finally {
        this.uploadingPdf = false;
      }
    },
    handleDrop(event) {
      const file = event.dataTransfer.files[0];
      if (file) {
        this.handlePdfChange({ target: { files: [file] } });
      }
    },
    triggerFileInput() {
      document.getElementById(`hidden-file-input-${this.id}`).click();
    },
  },
};
</script>
