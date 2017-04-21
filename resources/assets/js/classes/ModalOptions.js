export default class {
    constructor(title = '', body = '', textAcceptBtn = '', textCancelBtn = '', isCancelBtn = false, data = {})
    {
        this.title = title,
        this.body = body,
        this.textAcceptBtn = textAcceptBtn,
        this.textCancelBtn = textCancelBtn,
        this.isCancelBtn = isCancelBtn,
        this.data = data
    }
}