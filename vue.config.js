module.exports = {
    devServer: {
        proxy: {
            target: 'http://proxy.test/',
            ws: true,
            changeOrigin: true
        }
    },
};