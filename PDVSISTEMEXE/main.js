const { app, BrowserWindow } = require('electron')

const createWindow = () => {
    const win = new BrowserWindow({
        width: 1280,
        height: 720
    })

    win.loadURL('http://172.31.200.121:53053')
}

app.whenReady().then(() => {
    createWindow()
})