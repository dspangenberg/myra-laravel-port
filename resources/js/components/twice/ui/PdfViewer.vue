<script setup lang="ts">
import { VuePDF } from '@tato30/vue-pdf'
import { onMounted, ref, toRefs, watch } from 'vue'
import { IconDownload, IconPrinter, IconChevronRight, IconChevronLeft } from '@tabler/icons-vue'
import * as PDFJS from 'pdfjs-dist'
import * as pdfjsWorker from 'pdfjs-dist/build/pdf.worker.mjs'
import print from 'print-js'
import { Modal } from 'jenesius-vue-modal'
interface Props {
  isOpen?: boolean
  dataUrl?: string | null
  base64: string
}

interface PdfMetadata {
  info: {
    Author: string
    CreationDate: string
    Creator: string
    ModDate: string
    Producer: string
    Subject: string
    Title: string
    Trapped: string
  }
}

const props = withDefaults(defineProps<Props>(), {
  isOpen: false,
  dataUrl: null
})

const { dataUrl, base64 } = toRefs(props)
const pdf = ref()
const numPages = ref(1)
const page = ref(1)

const title = ref('PDF-Anzeige')

const onDownload = async () => {
  if (dataUrl.value) {
    const link = document.createElement('a')
    link.href = dataUrl.value
    link.setAttribute('download', 'file.pdf')
    document.body.appendChild(link)
    link.click()
  }
}

const onPrint = async () => {
  print({
    printable: base64.value,
    type: 'pdf',
    base64: true
  })
}

watch(dataUrl, async (dataUrl) => {
  if (dataUrl) {
    const loadingTask = PDFJS.getDocument(dataUrl)
    if (loadingTask) {
      try {
        page.value = 1
        const pdfDoc = await loadingTask.promise
        const metadata: PdfMetadata = await pdfDoc.getMetadata() as unknown as PdfMetadata
        numPages.value = pdfDoc.numPages
        pdf.value = loadingTask
        title.value = metadata.info.Title || 'PDF-Anzeige'
      } catch (error) {}
    }
  }
}, { immediate: true })

onMounted(async () => {
  try {
    PDFJS.GlobalWorkerOptions.workerSrc = pdfjsWorker
  } catch (error) {}
})

const emit = defineEmits([Modal.EVENT_PROMPT])

const onHide = () => {
  emit(Modal.EVENT_PROMPT, false)
}

const onNextPage = () => {
  if (page.value < numPages.value) {
    page.value++
  }
}

const onPrevPage = () => {
  if (page.value > 1) {
    page.value--
  }
}

</script>
<template>
  <div>
    <TwiceUiDialog
      :show="true"
      width="lg"
      :title="title"
      @hide="onHide"
    >
      <template #toolbar>
        <div class="flex items-center">
          <shdn-ui-button
            :disabled="page === 1"
            size="icon"
            variant="ghost"
            @click="onPrevPage"
          >
            <IconChevronLeft class="size-5" />
          </shdn-ui-button>
          <shdn-ui-button
            :disabled="page === numPages || numPages === 1"
            size="icon"
            variant="ghost"
            @click="onNextPage"
          >
            <IconChevronRight class="size-5" />
          </shdn-ui-button>
          <shdn-ui-button
            size="icon"
            variant="ghost"
            @click="onDownload"
          >
            <IconDownload class="size-5" />
          </shdn-ui-button>
          <shdn-ui-button
            size="icon"
            variant="ghost"
            @click="onPrint"
          >
            <IconPrinter class="size-5" />
          </shdn-ui-button>
        </div>
      </template>
      <template #content>
        <VuePDF
          v-if="pdf"
          id="pdf"
          :page="page"
          class="border mx-auto my-6"
          :pdf="pdf"
        />
      </template>
      <template #secondary-actions>
        <div class="text-sm">
          {{ page }}/{{ numPages }} Seiten
        </div>
      </template>
      <template #footer>
        <twice-ui-button @click="onHide">
          Schließen
        </twice-ui-button>
      </template>
    </TwiceUiDialog>
  </div>
</template>
