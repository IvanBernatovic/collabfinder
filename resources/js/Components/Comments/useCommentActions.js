import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'
import { COMMENT_MESSAGES } from './constants'

export function useCommentActions() {
  const toast = useToast()

  const editForm = useForm({
    content: ''
  })

  const isEditing = ref(false)
  const editContent = ref('')

  const startEdit = (comment) => {
    isEditing.value = true
    editContent.value = comment.content
    editForm.content = comment.content
  }

  const cancelEdit = (originalContent) => {
    isEditing.value = false
    editContent.value = originalContent
  }

  const updateComment = async (commentId, content, onSuccess = () => { }) => {
    editForm.content = content

    editForm.put(`/comments/${commentId}`, {
      onSuccess: () => {
        isEditing.value = false
        toast.success(COMMENT_MESSAGES.UPDATE_SUCCESS)
        onSuccess()
      },
      onError: () => {
        toast.error(COMMENT_MESSAGES.UPDATE_ERROR)
      }
    })
  }

  const deleteComment = async (commentId, onSuccess = () => { }) => {
    if (confirm(COMMENT_MESSAGES.DELETE_CONFIRM)) {
      editForm.delete(`/comments/${commentId}`, {
        onSuccess: () => {
          toast.success(COMMENT_MESSAGES.DELETE_SUCCESS)
          onSuccess(commentId)
        },
        onError: () => {
          toast.error(COMMENT_MESSAGES.DELETE_ERROR)
        }
      })
    }
  }

  return {
    editForm,
    isEditing,
    editContent,
    startEdit,
    cancelEdit,
    updateComment,
    deleteComment
  }
}
