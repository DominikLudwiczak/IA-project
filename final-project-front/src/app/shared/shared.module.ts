import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AlertComponent } from './alert/alert.component';
import { ConfirmComponent } from './confirm/confirm.component';



@NgModule({
  declarations: [
    AlertComponent,
    ConfirmComponent
  ],
  imports: [
    BrowserModule,
    CommonModule,
    HttpClientModule,    
    FormsModule,
    ReactiveFormsModule
  ],
  exports: [
    BrowserModule,
    CommonModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
    AlertComponent,
    ConfirmComponent
  ]
})
export class SharedModule { }
