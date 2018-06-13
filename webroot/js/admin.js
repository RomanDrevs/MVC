/**
 * Чтобы избежать случайного удаления страницы используем javascript confirmation for user. Хорошая практика для
 * написания приложений. Ф-я confirmDelete использ. для подтверждения удаления в любых частях Админ панели.
 */
function confirmDelete(){
    if (confirm("Delete this item?")){ //для выдачи предупреждений используем стандартную js ф-ю confirm
        return true;
    }else{
        return false;
    }
}

