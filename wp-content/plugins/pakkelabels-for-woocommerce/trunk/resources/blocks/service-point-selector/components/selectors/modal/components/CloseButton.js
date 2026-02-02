export default function CloseButton({onClose}) {

    const close = (e) => {
        e.preventDefault()
        onClose()
    }

    return (
        <button className={'shipmondo-modal_close'} onClick={close}>
            <span aria-hidden="true">&times;</span>
        </button>
    )
}