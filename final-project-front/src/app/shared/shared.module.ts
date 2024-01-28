import { NgModule } from '@angular/core';
import { CommonModule, DatePipe } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AlertComponent } from './alert/alert.component';
import { ConfirmComponent } from './confirm/confirm.component';
import { MaterialsModule } from '../materials/materials.module';



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
    ReactiveFormsModule,
    MaterialsModule
  ],
  exports: [
    BrowserModule,
    CommonModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
    AlertComponent,
    ConfirmComponent
  ],
  providers: [
    DatePipe
  ]
})
export class SharedModule { }
