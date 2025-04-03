<template>
  <section class="PdfUpload">
    <div
      v-if="!pdfUrl"
      class="UploadContainer w-full relative clickable flex-center h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 p-1"
    >
      <input
        :id="`dropzone-file-${id}`"
        :name="`dropzone-file-${id}`"
        type="file"
        class="clickable absolute top-0 left-0 right-0 bottom-0 w-full h-full block opacity-0"
        accept="application/pdf"
        @change="handlePdfChange"
        required
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
          <div class="flex flex-col items-center justify-center space-y-2">
            <img
              src="../../assets/pdf-icon.svg"
              alt="pdf logo"
              class="img-fluid h-12 w-12"
            />
            <p class="text-sm text-gray-500">
              <span class="font-semibold">Click to upload</span> or drag and
              drop
            </p>
            <p class="text-sm text-gray-500">
              File Formats Accepted: <span class="font-semibold">PDF</span>
            </p>
            <p class="text-sm text-gray-500">
              Max File Size: <span class="font-semibold">25MB</span>
            </p>
          </div>
        </label>
      </div>
      <div v-else-if="uploadingPdf" class="flex-center uploading">
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
    </div>
    <div v-else class="preview-uploaded">
      <div
        class="preview-pdf border-2 border-gray-300 border-dashed rounded-lg flex align-items-center justify-content-between p-2"
      >
        <a
          :href="pdfUrl"
          target="_blank"
          class="icon-name flex align-items-center"
        >
          <img
            src="../../assets/pdf-icon.svg"
            alt="pdf logo"
            class="img-fluid h-8 w-8 mr-2"
          />
          {{ fileName }}
        </a>
        <i class="fa-solid fa-lg fa-xmark clickable" @click="emitPDF('')"></i>
      </div>
    </div>
  </section>
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
    initialFileName: String,
  },
  data() {
    return {
      uploadingPdf: false,
      pdfUrl: this.initialPdf,
      fileName: this.initialFileName,
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
        this.emitFileName(selectedFile.name);

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
          this.emitPDF(url);
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
    emitPDF(url) {
      this.pdfUrl = url;
      this.$emit("pdfUploaded", url);
    },
    emitFileName(name) {
      this.fileName = name;
      this.$emit("pdfNameUpdate", name);
    },
  },
};
</script>
