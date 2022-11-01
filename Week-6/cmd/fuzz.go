package cmd

import (
	"bufio"
	"fmt"
	"log"
	"net/http"
	"os"

	"github.com/spf13/cobra"
)

var fuzzCmd = &cobra.Command{
	Use:   "fuzz",
	Short: "Short Description Here",
	Long:  "\nWelcome to my fuzzer.\nYou need to use '--url' and '--wordlist' perimeter to fuzz a website that you want to fuzz.\n",
	Run: func(cmd *cobra.Command, args []string) {
		myUrl, _ := cmd.Flags().GetString("url")
		myWordList, _ := cmd.Flags().GetString("wordlist")

		if myUrl == "" || myWordList == "" {
			fmt.Println("Enter an url by using '--url=' and give a wordlist path")
		} else {
			myWordList, errorr := cmd.Flags().GetString("wordlist")
			if errorr != nil {
				log.Fatal(errorr)
			}
			// fmt.Println(myWordList)

			file, err := os.Open(myWordList)
			if err != nil {
				log.Fatal(err)
			}
			Scanner := bufio.NewScanner(file)
			// Scanner.Split(bufio.ScanWords)

			var i int = 1
			for Scanner.Scan() {
				resp, err := http.Get(myUrl + "/" + Scanner.Text())
				if err != nil {
					log.Fatal(err)
				}
				defer resp.Body.Close()
				if resp.StatusCode != 404 {
					fmt.Print(i, "  -  ")
					i++
					fmt.Println(myUrl + "/" + Scanner.Text())
				}
			}
		}
	},
}

func init() {
	rootCmd.AddCommand(fuzzCmd)

	fuzzCmd.PersistentFlags().String("url", "", "Search with given url")
	fuzzCmd.PersistentFlags().String("wordlist", "", "Search with given wordlist")
}
