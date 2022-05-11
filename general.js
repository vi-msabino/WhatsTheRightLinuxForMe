let zahl=0
        function onClick(button){
            var root=document.querySelector(':root')
            if(zahl==1){
                root.style.setProperty('--bc', '#F8F9FA')
                root.style.setProperty('--tc', '#343A40')
                zahl--
            }else {
                root.style.setProperty('--bc', '#343A40')
                root.style.setProperty('--tc', '#F8F9FA')
                zahl++
            }
        }