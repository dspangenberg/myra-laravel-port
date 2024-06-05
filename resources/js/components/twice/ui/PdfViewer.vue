<script setup lang="ts">
import { VuePDF } from '@tato30/vue-pdf'
import { onMounted, ref, toRefs, watch } from 'vue'
import { IconDownload, IconPrinter } from '@tabler/icons-vue'
import * as PDFJS from 'pdfjs-dist'
import * as pdfjsWorker from 'pdfjs-dist/build/pdf.worker.mjs'
import print from 'print-js'

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

const title = ref('PDF-Anzeige')

defineEmits(['close'])

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
      const pdfDoc = await loadingTask.promise
      const metadata: PdfMetadata = await pdfDoc.getMetadata() as unknown as PdfMetadata
      pdf.value = loadingTask
      title.value = metadata.info.Title || 'PDF-Anzeige'
    }
  }
}, { immediate: true })

onMounted(async () => {
  try {
    PDFJS.GlobalWorkerOptions.workerSrc = pdfjsWorker
  } catch (error) {}
})

</script>
<template>
  <div>
    <TwiceUiDialog
      :show="isOpen"
      width="lg"
      :title="title"
      @hide="$emit('close')"
    >
      <template #toolbar>
        <div class="flex items-center">
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
          id="pdf"
          class="border mx-auto max-w-[600px] my-6"
          :pdf="pdf"
        />
      </template>
      <template #footer>
        <TwiceUiButton @click="$emit('close')">
          Schließen
        </TwiceUiButton>
      </template>
    </TwiceUiDialog>
  </div>
</template>
