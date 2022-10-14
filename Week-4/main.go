package main

import (
	"fmt"
	"io"
	"os"
	"time"
)

func main() {
	fmt.Print("Hoş geldiniz! Sisteme erişmek için lütfen kullanıcı adı ve parolanız ile giriş yapınız! (Toplam giriş hakkınız 5' tir)\n\n")

	const Username = "admin"
	const Password = "password"

	var myUsername, myPassword string

	file, err := os.Create("logs.txt")
	if err != nil {
		panic(err)
	}

	for i := 5; i > 0; i-- {
		myTime := time.Now()

		fmt.Print("Kullanıcı adı: ")
		fmt.Scanf("%s\n", &myUsername)
		fmt.Print("Parola: ")
		fmt.Scanf("%s\n", &myPassword)

		if myUsername == Username && myPassword == Password {
			io.WriteString(file, "Kullanıcı adı: "+myUsername+"\nParola: "+myPassword+"\nDurum: Başarılı\nZaman: "+myTime.Format("01-02-2006 15:04:05")+"\n\n")
			fmt.Print("\nKullanıcı adı: ", myUsername, "\nParola: ", myPassword, "\nGiriş Başarılı!\n\n")
			break
		} else {
			io.WriteString(file, "Kullanıcı adı: "+myUsername+"\nParola: "+myPassword+"\nDurum: Başarısız\nZaman: "+myTime.Format("01-02-2006 15:04:05")+"\n\n")
			fmt.Print("\nKullanıcı adı: ", myUsername, "\nParola: ", myPassword, "\nHatalı giriş yaptınız!\nKalan deneme hakkı = ", i-1, "\n\n")
		}
	}

	file.Close()
}
