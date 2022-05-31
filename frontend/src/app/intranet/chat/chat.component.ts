import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import {FormControl, FormGroup, Validators, } from '@angular/forms';
import { ChatMessageDto } from 'src/app/core/models/chat/chatMessageDto';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage.service';
import { WebSocketService } from 'src/app/core/shared/services/web-socket.service';

@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.scss']
})
export class ChatComponent implements OnInit {
  formularioEnvio = new FormGroup({
    user: new FormControl(''),
    message: new FormControl('')
  });

  constructor(
    public webSocketService:WebSocketService,
    private token:TokenStorageService
    ) { }

  ngOnInit(): void {
    this.webSocketService.openWebSocket();
  }

  ngOnDestroy(): void {
    this.webSocketService.closeWebSocket();
  }

  sendMessage() {
    const chatMessageDto = new ChatMessageDto(this.token.getUser().nombre, this.formularioEnvio.value.message, "Mensaje");
    this.webSocketService.sendMessage(chatMessageDto);
    this.formularioEnvio.value.message = "";
  }
}

