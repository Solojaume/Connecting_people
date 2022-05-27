import { Component, OnInit, OnDestroy } from '@angular/core';
import { NgForm } from '@angular/forms';
import { ChatMessageDto } from 'src/app/core/models/chatMessageDto';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage.service';
import { WebSocketService } from 'src/app/core/shared/services/web-socket.service';
import { FormControl } from '@angular/forms';
@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.scss']
})
export class ChatComponent implements OnInit,OnDestroy {


  constructor(public webSocketService: WebSocketService,private token:TokenStorageService) { }

  ngOnInit(): void {
    this.webSocketService.openWebSocket();
  }

  ngOnDestroy(): void {
    this.webSocketService.closeWebSocket();
  }

  sendMsg(sendForm: NgForm) {
    const chatMessageDto = new ChatMessageDto(this.token.getUser().nombre, sendForm.value.message);
    this.webSocketService.sendMessage(chatMessageDto);
    console.log(sendForm);
    //sendForm.controls.message.reset();
  }
}

