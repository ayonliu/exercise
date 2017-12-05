var StateMain = {

    preload: function () {
    	game.load.spritesheet("buttons","images/buttons.png",144,68,2);
    },

    create: function () {

    	this.text1=game.add.text(game.width/2,0,"0");
    	this.text1.anchor.set(0.5,0);
    	this.text1.fill="#ffffff";

    	//create 2 buttons
        this.button1=this.makeButton(game.width/2,game.height*.25,1);
        this.button2=this.makeButton(game.width/2,this.button1.y+this.button1.height*1.1,2);

        //add animation to the 2nd button
        this.button2.animations.add("auto",[0,0,0,0,0,0,1],3,true);
        this.button2.animations.play("auto");
    },
    /**
     * Function to make a copy of the button template
     */
    makeButton(xx,yy,index)
    {
    	var button=game.add.sprite(xx,yy,"buttons");
    	button.index=index;
        button.anchor.set(0.5,0.5);
        button.inputEnabled=true;
        button.events.onInputDown.add(this.buttonPressed,this);
        button.events.onInputUp.add(this.buttonReleased,this);
        return button;
    },
    buttonPressed(target)
    {
    	//show the down frame
    	target.frame=1;
    	this.text1.text=target.index;
    },
    buttonReleased(target)
    {
    	//show the up frame
    	target.frame=0;
    	this.text1.text=0;
    },
    update: function () {

    }

}