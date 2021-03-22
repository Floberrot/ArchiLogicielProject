export default {
    isConnected (to, from, next) {
        var isAuthenticated = false
        if (localStorage.getItem('token')) {
            isAuthenticated = true
        } else {
            isAuthenticated = false
        }
        if (isAuthenticated) {
            next()
        } else {
            next('/login')
        }
    },
}
