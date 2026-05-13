function getCart(){
    return JSON.parse(localStorage.getItem("cart")) || [];
}


function saveCart(cart){
    localStorage.setItem("cart", JSON.stringify(cart));
}



function updateNavCount(){

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let count = 0;

    cart.forEach(item => {
        count += item.qty;
    });


    document.getElementById("count").innerText = count;
}

function addToCart(id, name, price, image){
    count++;
    document.getElementById("count").innerText = count;
    let cart = getCart();
  let item = cart.find(p => p.id === id);

    if(item){
        item.qty++;
    }else{
        cart.push({ id, name, price, image, qty: 1 });
    }

    saveCart(cart);
    displayCart();
updateSummary();
}

updateNavCount();

function displayCart(){
 let cart = getCart();
 let container = document.getElementById("cart_items");
    container.innerHTML = "";
 let total = 0;
 document.querySelector(".count_item_cart").innerText = cart.length;
  cart.forEach(item => {

    let subtotal = item.price * item.qty;
        total += subtotal;
   container.innerHTML += `
        <div class="item_cart">
          <img src="images/${item.image}" />
         <div class="content">
                <h4>${item.name}</h4>
                <p class="price_cart">${item.price} EGP</p>

                <div class="quantity_control">
                    <button onclick="decreaseQty(${item.id})">-</button>
                    <span class="quantity">${item.qty}</span>
                    <button onclick="increaseQty(${item.id})">+</button>
                </div>
            </div>


 <button onclick="removeItem(${item.id})" class="delete_item" >
 <i class="fa-solid fa-trash-can"></i>
 </button>
        </div>
        `;
    });



    document.querySelector(".price_cart_total").innerText = total + " EGP";
    updateNavCount();
}


function increaseQty(id){
    let cart = getCart();
    let item = cart.find(p => p.id === id);
    if(item) item.qty++;
    saveCart(cart);
    displayCart();
    updateNavCount();
    updateSummary();
}


function decreaseQty(id){
    let cart = getCart();
    let item = cart.find(p => p.id === id);

    if(item){
        item.qty--;
        if(item.qty <= 0){
            cart = cart.filter(p => p.id !== id);
        }
    }

    saveCart(cart);
    displayCart();
    updateNavCount();
    updateSummary();
}


function removeItem(id){
    let cart = getCart();
    cart = cart.filter(p => p.id !== id);
    saveCart(cart);
    displayCart();
    updateNavCount();
    updateSummary();
}




function open_close_cart(){
    document.querySelector(".cart").classList.toggle("active");
}




function calculateDelivery(cost) {
    if (cost >= 1500 || cost==0) {
        return 0;  
    } else if (cost >= 500) {
        return 50;
    } else {
        return 80;
    }
}




function updateSummary() {
    let cart = getCart();
    let cost = 0;
    let totalQuantity = 0;
   
    cart.forEach(item => {
        cost += item.price * item.qty;
        totalQuantity += item.qty;
    });
   
    let delivery = calculateDelivery(cost);
    let totalPrice = cost + delivery;
   
    let totalQtyElem = document.getElementById("total_quantity");
    let costElem = document.getElementById("cost");
    let deliveryElem = document.getElementById("delivery");
    let totalPriceElem = document.getElementById("total_price");
   
    if (totalQtyElem) totalQtyElem.innerText = totalQuantity;
    if (costElem) costElem.innerText = cost;
    if (deliveryElem) deliveryElem.innerText = delivery;
    if (totalPriceElem) totalPriceElem.innerText = totalPrice;
}



window.onload = function(){
    displayCart();
    updateNavCount();
    updateSummary();
}



function toggleDropdown(){
    var menu = document.getElementById("dropdown");
    if(menu)
    document.getElementById("dropdown").classList.toggle("show");
}

window.onclick = function(event){
    if (! event.target.matches('.profile-img')){

        var dropdowns = document.getElementsByClassName("dropdown-menu");
       
        for( var i = 0; i < dropdowns.length; i++){
            var openDropDown = dropdowns[i];
            if(openDropDown.classList.contains('show')){
                openDropDown.classList.remove('show');
            }
        }
    }
}


