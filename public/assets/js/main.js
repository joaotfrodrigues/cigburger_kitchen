// watch
const watch = document.getElementById('top_watch');
if (watch) {
    let watch_time = new Date();
    watch.innerHTML = watch_time.toLocaleTimeString('pt-PT');

    setInterval(() => {
        let watch_time = new Date();
        watch.innerHTML = watch_time.toLocaleTimeString('pt-PT');
    }, 1000);
}
